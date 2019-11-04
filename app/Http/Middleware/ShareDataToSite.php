<?php

namespace App\Http\Middleware;

use Closure;
use Request;
use Auth;
use View;

class ShareDataToSite {
    
     public function __construct() {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        View::share('lang_code',getLocale());

        return $next($request);
    }

}
