<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Repositories\Contracts\UserRepositoryInterface;
use App\Models\Group;

//use My;

class LoginController extends Controller {

    use AuthenticatesUsers;
    
    private $user;
    public function __construct(UserRepositoryInterface $user) {
        $this->middleware('guest:admin', ['except' => ['logout']]);
        $this->user=$user;
    }

    public function showLoginForm() {

        return view('main_content/admin/login');
    }

    public function login(LoginRequest $request) {
        try {
            $username = $request->input('username');
            $password = $request->input('password');
            $admin = $this->user->check_auth([
                        'username' => $request->input('username'),
                        'password' => $request->input('password'),
                        'type' => config('constants.users.admin_type'),
            ]);
//            dd($admin);
            if (!$admin) {
                return bad_request(t('invalid_credentials'));
            }
            Auth::guard('admin')->login($admin);
            $redirect = route('admin.dashboard');
            return ok(['url' => $redirect]);
        } catch (\Exception $ex) {
            dd($ex);
            return bad_request(t('error_is_occured'));
        }
    }


    public function logout() {
        Auth::guard('admin')->logout();
        return redirect(route('admin.login'));
    }

}
