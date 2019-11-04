<?php

namespace App\Models\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Repositories\Contracts\AttachmentFileRepositoryInterface;
use Image;

abstract class BaseRepository {

    protected $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }

    /*
     * Return Created Entity
     * @return Illuminate\Database\Eloquent\Model
     */

    public function getModel() {
        return $this->model;
    }

    protected function getLangCode() {
        $lang_code = app()->getLocale();

        return $lang_code;
    }

    protected function log($performed_on, $user,$log_name, $description, $properties = []) {
        activity()
                ->useLog($log_name)
                ->performedOn($performed_on)
                ->causedBy($user)
                ->withProperties($properties)
                ->log($description);
    }

    protected static function handleKeywordWhere($columns, $keyword) {
        $search_exploded = explode(" ", $keyword);
        $i = 0;
        $construct = "( ";
        foreach ($columns as $col) {
            //pri($col);
            $x = 0;
            $i++;
            if ($i != 1) {
                $construct .= " OR ";
            }
            foreach ($search_exploded as $search_each) {
                $x++;
                if (count($search_exploded) > 1) {
                    if ($x == 1) {
                        $construct .= "($col LIKE '%$search_each%' ";
                    } else {
                        $construct .= "AND $col LIKE '%$search_each%' ";
                        if ($x == count($search_exploded)) {
                            $construct .= ")";
                        }
                    }
                } else {
                    $construct .= "$col LIKE '%$search_each%' ";
                }
            }
        }
        $construct .= " )";
        return $construct;
    }

    protected static function rmv_prefix($old_image) {
        return substr($old_image, strpos($old_image, '_') + 1);
    }

    protected static function iniDiffLocations($tableName, $lat, $lng) {
        $diffLocations = "SQRT(POW(69.1 * ($tableName.lat - {$lat}), 2) + POW(69.1 * ({$lng} - $tableName.lng) * COS($tableName.lat / 57.3), 2)) as distance";
        return $diffLocations;
    }

    protected static function getListBetweenTwoDatesForQuery($date_from, $date_to) {
        $dates = GetDays($date_from, $date_to);
        array_pop($dates);
        $sql = '';
        if (count($dates) > 0) {
            $first = $dates[0];

            foreach ($dates as $key => $one) {
                if ($key == 0) {
                    $sql .= "select STR_TO_DATE('$one' , '%Y-%m-%d') as selected_date ";
                } else {
                    $sql .= "union all select STR_TO_DATE('$one' , '%Y-%m-%d') as selected_date ";
                }
            }
        }
//        dd($sql);
        return $sql;
    }

    protected static function getListForQuery($list = array()) {
        $sql = '';
        if (count($list) > 0) {
            foreach ($list as $key => $one) {
                if ($key == 0) {
                    $sql .= "select $one as meal_plan ";
                } else {
                    $sql .= "union all select $one as meal_plan ";
                }
            }
        }
//        dd($sql);
        return $sql;
    }
      public function transform_attachment($items) {

        $transformers = array();
        if ($items->count() > 0) {
            foreach ($items as $item) {
//                dd($item);
                $transformer = new \stdClass();
                $transformer->id = $item->id;
                $transformer->field = $item->field;
                $transformer->url = url_upload_path($item->dir . '/' . $item->file_name);
                $transformer->background = url_upload_path($item->dir . '/' . $item->file_name);
                $transformers[$item->field][] = $transformer;
            }
        }
//        dd($transformers);
        return $transformers;
    }
    public function upload($file, $resize = false, $sizes_type = false, $attachment_id = NULL) {
        $image = '';
        $upload_folder = $this->model->upload_folder;
//        dd($this->model);
        $path = upload_path("$upload_folder");
        $filename = time() . mt_rand(1, 1000000) . '.' . strtolower($file->getClientOriginalExtension());


        $image = Image::make($file);
        $names = array();
        if ($resize) {

            if (isset($this->model->sizes) && !empty($this->model->sizes)) {
                $sizes = ($sizes_type) ? $this->model->sizes[$sizes_type] : $this->model->sizes;
                foreach ($sizes as $prefix => $size) {
                    $path_with_filename = $path . '/' . $prefix . '_' . $filename;
                    $image->backup();
                    if ($size['width'] == null && $size['height'] != null) {
                        //dd($prefix);
                        $image->resize(null, $size['height'], function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } else if ($size['height'] == null && $size['width'] != null) {
                        $image->resize($size['width'], null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } else {
                        $image->resize($size['width'], $size['height']);
                    }


                    $image = $image->save($path_with_filename, 100);
                    $image->reset();
                    $names[] = $image->basename;
                    //$image->reset();
                }
//                dd($this->attachment);
                $attachment=app(AttachmentFileRepositoryInterface::class);
                $AttachmentFile = $attachment->create(['field' => $sizes_type, 'dir' => $upload_folder, 'file_name' => $names[0], 'mime_type' => $image->mime(), 'attachment_id' => $attachment_id, 'attachment_type' => get_class($this->model)]);
                $uploaded['id'] = $AttachmentFile->id;
                $uploaded['url'] = url_upload_path("$upload_folder/$names[0]");
                $uploaded['background'] = url_upload_path("$upload_folder/$names[0]");
                return $uploaded;
            }
        }
        $path_with_filename = $path . '/' . $filename;
        $image = $image->save($path_with_filename);
        return $image->basename;
    }

    protected static function deleteUploaded($attachment) {

        $field = $attachment->field;
        $model = $attachment->attachment_type;
        $folder = $model::$upload_folder;
        $old_image = $attachment->file_name;
        if (in_array($old_image, ['default.png', 'male.png', 'female.png'])) {
            return;
        }
        if (isset($model::$sizes) && isset($model::$sizes[$field]) && !empty($model::$sizes[$field])) {
            $files = array();
            $image_without_prefix = substr($old_image, strpos($old_image, '_') + 1); //without s_
//            dd($model::$sizes[$field]);
            foreach ($model::$sizes[$field] as $prefix => $size) {
                $files[] = public_path("uploads/$folder/$prefix" . "_" . "$image_without_prefix");
            }
            if (!empty($files)) {
                foreach ($files as $file) {
                    if (!is_dir($file)) {
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                }
            }
        } else {
            $file = public_path("uploads/$folder/$old_image");
            if (!is_dir($file)) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
        //dd('sss');
    }

    protected function upload_simple($file, $path) {
        $image = '';
        $path = public_path() . "/uploads/$path";
        $filename = time() . mt_rand(1, 1000000) . '.' . $file->getClientOriginalExtension();
        if ($file->move($path, $filename)) {
            $image = $filename;
        }
        return $image;
    }

    public static function buildTree($elements, $parentId = 0) {
        $branch = array();
        foreach ($elements as $element) {
            if ($element->parent_id == $parentId) {
                $children = static::buildTree($elements, $element->id);
                if ($children) {
                    $element->children = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    public static function buildTreeDropDown($elements, $parentId = null) {

        $html = '';
        foreach ($elements as $element) {
            //dd($elements);
            if ($element->parent_id == $parentId) {
                //dd('here');
                $html .= '<option value="' . $element->id . '" data-text="' . $element->text . '">' . str_repeat('-', $element->level) . $element->text . '</option>';
                $children = static::buildTreeDropDown($elements, $element->id);

                if ($children) {
                    $html .= $children;
                }
            }
        }
        return $html;
    }

}
