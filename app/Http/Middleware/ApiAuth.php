<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class ApiAuth
{
    /**
     * @param $request
     * @param Closure $next
     * @param string $guard
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function handle($request, Closure $next,$guard='api')
    {
        if (Auth::guard($guard)->check() && Auth::guard($guard)->user()->status == 1) {
            return $next($request);
        }
        return prompt('用户验证失败，请重新登录','error');
    }
}
