<?php

namespace App\Models\Repositories;

use App\Models\AttachmentFile;
use App\Models\CurrencyTranslation;
use App\Models\Repositories\Contracts\AttachmentFileRepositoryInterface;
use App\Models\Repositories\BaseRepository;
use Auth;
use DB;

class AttachmentFileRepository extends BaseRepository implements AttachmentFileRepositoryInterface {

    protected $model;

    /**
     * UserRepository constructor.
     * @param App\Models\AttachmentFile $attachment
     */
    public function __construct(AttachmentFile $attachment) {
        $this->model = $attachment;
    }

    /**
     * insert new record
     * 
     * @param array $data
     * @return App\Models\AttachmentFile
     */
    public function create($data = []) {
        return $this->model->create([
                    'dir' => $data['dir'],
                    'field' => $data['field'],
                    'file_name' => $data['file_name'],
                    'mime_type' => $data['mime_type'],
                    'attachment_id' => isset($data['attachment_id']) ? $data['attachment_id'] : NULL,
                    'attachment_type' => $data['attachment_type'],
        ]);
    }

    /**
     * assign attachment id to uploaded
     * 
     * @param array $data
     * @return void
     */
    public function assignToAttachment($attachment_id, $new_attachment = []) {
        $this->model->whereIn('id', $new_attachment)->update(['attachment_id' => $attachment_id]);
    }

    /**
     * delete record
     * 
     * @param int $id
     * @return void
     */
    public function delete($id) {
        $this->model->where('id', $id)->delete();
    }

    /**
     * find one for edit
     * 
     * @param int $id
     * @return App\Models\AttachmentFile
     */
    public function findById($id) {
        $data = $this->model->find($id);
        return $data;
    }

    public function transform($items) {

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

}
