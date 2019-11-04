<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\ApiFormRequest;

class LoginRequest extends ApiFormRequest {

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
            'username' => 'required',
            'password' => "required",
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
                    return array();
                }
        }
    }

}
