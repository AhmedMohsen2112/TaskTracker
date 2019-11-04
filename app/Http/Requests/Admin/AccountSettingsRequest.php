<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;
use App\Models\Employee;
use Illuminate\Validation\Rule;
use App\Models\Repositories\Contracts\UserRepositoryInterface;

class AccountSettingsRequest extends ApiFormRequest {

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
                    );
                    return $rules;
                }
            case 'PUT': {
                    return array(
                    );
                }

            case 'PATCH': {
                   $User = app(UserRepositoryInterface::class)->auth_user('admin');
                    return array(
                        'name' => 'required',
                        'username' => [Rule::unique('users', 'username')->where(function ($query) use($User) {
                                        return $query->where('id', '!=', $User->id)
                                                        ->whereNotNull('username');
                                    })],
                        'phone' => 'required|unique:users,phone,' . $User->id,
                        'email' => 'required|unique:users,email,' . $User->id,
                    );
                }
        }
    }

}
