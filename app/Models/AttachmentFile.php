<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttachmentFile extends Model {

    /**
     * table name
     *
     * @var string
     */
    protected $table = "attachment_files";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['field','dir', 'mime_type', 'file_name', 'title', 'description', 'url', 'attachment_id', 'attachment_type'];

    /**
     * relationships
     *
     */
    public function attachment() {
        return $this->morphTo();
    }

    protected static function deleteUploaded($attachment) {
    
        $field = $attachment->field;
        $model = new $attachment->attachment_type;
        $folder = $attachment->dir;
        $old_image = $attachment->file_name;
        if (in_array($old_image, ['default.png', 'male.png', 'female.png'])) {
            return;
        }
        if (isset($model->sizes) && isset($model->sizes[$field]) && !empty($model->sizes[$field])) {
            $files = array();
            $image_without_prefix = substr($old_image, strpos($old_image, '_') + 1); //without s_
            foreach ($model->sizes[$field] as $prefix => $size) {
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

    protected static function boot() {
        parent::boot();

        static::deleting(function($attachment) {



            static::deleteUploaded($attachment);
        });
        static::deleted(function($work) {
            
        });
    }

}
