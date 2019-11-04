<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;
use Auth;

class UserEditRequest extends ApiFormRequest {

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
        $user = Auth::guard('client')->user();
        $rules = array(
            'name' => "required",
            'username' => "required|unique:users,username," . $user->id,
            'phone' => 'required|unique:users,phone,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'confirm_password' => 'same:password',
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
                    //dd($this->id);
                    return array(
                    );
                }
        }
    }

}
