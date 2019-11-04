<?php

namespace App\Http\Transformers\Users;

use App\Http\Transformers\AbstractTransformer;
use App\Models\User;

class UserSearchTransformer extends AbstractTransformer {

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
        ];
    }


}
