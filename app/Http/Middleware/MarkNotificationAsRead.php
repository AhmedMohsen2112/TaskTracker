<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Repositories\NotiRepository;
use Cookie;
use View;

class MarkNotificationAsRead {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $noti;

    /**
     * Create a new filter instance.
     *
     */
    public function __construct(NotiRepository $noti) {
        $this->noti = $noti;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $noti_id= request()->input('noti_id');
        if($noti_id){
            $this->noti->markAsReadByNotifier();
        }
        
        if ($request->hasCookie('CurrentLang')) {
            $current_lang = Cookie::get('CurrentLang');
            View::share('lang_code', $current_lang);
            app()->setLocale($current_lang);
            return $next($request);
        }
        $current_lang = 'en';
        View::share('lang_code', $current_lang);
        app()->setLocale($current_lang);
        $response = $next($request);
        return $response->withCookie(Cookie::make('CurrentLang', $current_lang, 7 * 60 * 24));
    }

}
