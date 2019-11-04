<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Cookie;
use View;

class CheckCurrentLangCookie {

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
    public function __construct() {
        $this->auth = Auth();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        
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
