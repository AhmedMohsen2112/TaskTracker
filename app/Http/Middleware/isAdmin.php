<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Repositories\Contracts\NotiRepositoryInterface;
use App\Models\Repositories\Contracts\UserRepositoryInterface;
use View;

class isAdmin {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * The Noti Repository
     *
     * @var Guard
     */
    protected $noti;

    /**
     * The User Repository
     *
     * @var Guard
     */
    protected $user;

    /**
     * The Authenticated User
     *
     * @var Guard
     */
    protected $auth_user;

    /**
     * Create a new filter instance.
     *
     */
    public function __construct(NotiRepositoryInterface $noti, UserRepositoryInterface $user) {
        $this->auth = Auth();
        $this->noti = $noti;
        $this->user = $user;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        if ($this->auth->guard('admin')->check()) {
            $this->auth_user = $this->user->auth_user('admin');
//            dd($this->auth_user);
            if ($this->auth_user->type == config('constants.users.admin_type')) {
                if ($this->auth_user->active == 1) {
                    $this->share_data();
                    return $next($request);
                } else {
                    $this->auth->guard('admin')->logout();
                }
            }
        }
        if ($request->ajax()) {
            return unauthenticated(t('you_must_login_first'));
        } else {
            return redirect()->route('admin.login');
        }
    }

  
    private function share_data() {
//        dd($this->noti->getAll(['notifier_id' => $this->auth_user->id]));
        View::share('notifications', $this->noti->getAll(['notifier_id' => $this->auth_user->id]));
        View::share('unread_noti_count', $this->noti->unReadCount($this->auth_user->id));
        View::share('all_noti_count', $this->noti->allCount($this->auth_user->id));
        View::share('User', $this->auth_user);
    }

}
