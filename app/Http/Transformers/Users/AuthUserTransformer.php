<?php

namespace App\Http\Transformers\Users;

use App\Http\Transformers\AbstractTransformer;
use App\Models\User;

class AuthUserTransformer extends AbstractTransformer {

    /**
     * @param  $model
     * 
     * @return array
     */
    public function model($model) {

        return [
            'id' => $model->id,
            'name' => $model->name,
            'username' => $model->username,
            'email' => $model->email,
            'phone' => $model->phone,
            'type' => $model->type,
            'active' => $model->active,
        ];
    }

    public function withPermissions($model, $item) {
         $item->permissions = $model->group ? explode(',',$model->group->permissions) :[];
        return $item;
    }
    public function withHotelAssigned($model, $item) {
         $item->hotel_assigned = $model->hotel_assigned;
        return $item;
    }

}
