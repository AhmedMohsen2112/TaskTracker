<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\RegisterRequest;
use App\Models\Repositories\Contracts\UserRepositoryInterface;
use Auth;

class RegisterController extends Controller {

    use RegistersUsers;

    private $user;

    public function __construct(UserRepositoryInterface $user) {
        $this->middleware('guest:admin');
        $this->user = $user;
    }

    public function register(RegisterRequest $request) {
        try {
            $data = $request->all();
            $data['type'] = config('constants.users.admin_type');
            $data['active'] = 1;
            $User = $this->user->create($data);
            Auth::guard('admin')->login($User);
            $redirect = route('admin.dashboard');
            return ok(['url' => $redirect]);
        } catch (\Exception $ex) {
            dd($ex);
            return bad_request(t('error_is_occured'));
        }
    }

}
