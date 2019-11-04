<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;
use App\Models\Employee;
use Illuminate\Validation\Rule;

class UsersRequest extends ApiFormRequest {

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
        //dd($this->request->all());
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return array();
                }
            case 'POST': {
                    //dd($this->id);
                    $rules = array(
                        'name' => 'required',
                        'phone' => 'required|unique:users,phone',
                        'username' => ['required', Rule::unique('users', 'username')->where(function ($query) {
                                        return $query->whereNotNull('username');
                                    })],
                        'email' => 'required|unique:users,email',
//                        'group' => 'required',
                        'password' => 'required',
                        'active' => 'required'
                    );
                    return $rules;
                }
            case 'PUT': {
                    return array(
                    );
                }

            case 'PATCH': {
                    //dd($this->id);
                    return array(
                           'name' => 'required',
                        'username' => [Rule::unique('users', 'username')->where(function ($query) {
                                        return $query->where('id', '!=', $this->id)
                                                        ->whereNotNull('username');
                                    })],
                        'phone' => 'required|unique:users,phone,' . $this->id,
                        'email' => 'required|unique:users,email,' . $this->id,
//                        'group' => 'required',
                        'active' => 'required',
                    );
                }
        }
    }

}
