<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\AdminController;
use App\Models\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Requests\Admin\AccountSettingsRequest;
use App\Models\Group;

class ProfileController extends AdminController {

    private $user;

    public function __construct(UserRepositoryInterface $user) {
        parent::__construct();
        $this->user = $user;
    }

    public function index() {
        return $this->_view('profile/index');
    }

    public function update(AccountSettingsRequest $request) {

        try {
            $user = $this->user->findById($this->User->id);
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            if ($request->input('password')) {
                $user->password = bcrypt($request->input('password'));
            }
            $user->save();
            return ok(['message' => _lang('app.updated_successfully')]);
        } catch (\Exception $ex) {
            return bad_request(t('error_is_occured'));
        }
    }

}
