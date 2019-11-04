<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Repositories\NotiRepository;
use App\Models\Repositories\UserRepository;
use View;

class isClient {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     */
      public function __construct(NotiRepository $noti, UserRepository $user) {
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
        if ($this->auth->guard('client')->check()) {
            $this->auth_user = $this->user->auth_user('client');
//            dd($user);
            if ($this->auth_user->type == config('constants.users.individual_type') || $this->auth_user->type == config('constants.users.corporate_type')) {
//                dd($user);
                if ($this->auth_user->active == 1) {
                    $this->share_data();
                    return $next($request);
                } else {
                    Auth::guard($guard)->logout();
                }
            }
        }
//        dd($this->auth->guard('client')->check());
        if ($request->ajax()) {
            return unauthenticated(t('you_must_login_first'));
        } else {
            return redirect()->route('front.login');
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
