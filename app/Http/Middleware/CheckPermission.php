<?php

namespace App\Http\Middleware;

use Closure;


class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {

        if(checkPermission($permission, $request->method())){
            return $next($request);
        }

        //return response()->view('errors.check-permission');
        abort(403);
    }
}