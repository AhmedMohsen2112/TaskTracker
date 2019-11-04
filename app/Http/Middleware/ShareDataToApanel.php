<?php

namespace App\Http\Middleware;

use Closure;
use App\user;
use Request;
use Auth;
use View;

class ShareDataToApanel {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        
        View::share('locales',config('settings.locales'));

        return $next($request);
    }

}
