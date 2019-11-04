<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;

class BoardListsRequest extends ApiFormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules = array(
            'title' => 'required'
        );

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return array();
                }
            case 'POST': {
                    return $rules;
                }
            case 'PUT': {
                    return array(
                    );
                }

            case 'PATCH': {
                    return $rules;
                }
        }
    }

}
