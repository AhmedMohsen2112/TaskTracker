<?php

namespace App\Http\Transformers\BoardLists;

use App\Http\Transformers\AbstractTransformer;


class BasicTransformer extends AbstractTransformer {

    /**
     * @param  $model
     * 
     * @return array
     */
    public function model($model) {
        return [
            'id' => $model->id,
            'title' => $model->title,
            'issues' => $model->issues_data()
        ];
    }

}
