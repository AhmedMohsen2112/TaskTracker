<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
//    public function handle($request, Closure $next, $guard = null)
//    {
//        if (Auth::guard($guard)->check()) {
//            return redirect('/home');
//        }
//
//        return $next($request);
//    }
    public function handle($request, Closure $next, $guard = null) {
//        dd($guard);
        switch ($guard) {
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('admin.dashboard');
                }
                break;
            case 'client':
                   
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('home');
                }
                break;

            default:
                if (Auth::guard('web')->check()) {
                    return redirect()->route('front.home');
                }
                break;
        }

        return $next($request);
    }

}
