<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class CheckPermission {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $page, $permission = "open") {
        //abort(403);
     
        if (!\Permissions::check($page, $permission)) {
            
            if ($request->ajax()) {
                
                return _json('error', _lang('app.Access denied'),403);
            } else {
                App()->abort(403, 'Access denied');
                return redirect()->route('admin.error');
            }

            //return view('main_content/backend/err404');
        }
        return $next($request);
    }

}
