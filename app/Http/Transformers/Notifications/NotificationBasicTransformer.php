<?php

namespace App\Http\Transformers\Notifications;

use App\Http\Transformers\AbstractTransformer;
use App\Models\Repositories\Contracts\NotiObjectRepositoryInterface;
use App\Models\NotiObject;

class NotificationBasicTransformer extends AbstractTransformer {

    /**
     * @param  $model
     * 
     * @return array
     */
    public function model($model) {
        $noti_obiect_repo=app(NotiObjectRepositoryInterface::class);
        return [
            'noti_id' => $model->id,
            'noti_object_id' => $model->noti_object_id,
            'id' => $model->entity_id,
            'message' =>$noti_obiect_repo->message($model->entity_type_id, $model->entity_id, $model->username),
            'name' => $model->entity_id,
            'created_at' => \Carbon\Carbon::createFromTimeStamp(strtotime($model->created_at))->diffForHumans(),
            'read_status' =>$model->read_status,
            'entity_type' => $model->entity_type_id,
            'url' => $noti_obiect_repo->url($model->entity_type_id, $model->entity_id)
        ];
    }

}
