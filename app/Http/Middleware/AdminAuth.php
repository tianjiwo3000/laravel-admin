<?php

namespace App\Http\Middleware;

use App\Library\Y;
use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Auth\Factory as Auth;


class AdminAuth
{

    /**
     * auth
     * @var
     */
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * andle an incoming request.
     * @param $request
     * @param Closure $next
     * @param $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $guard = 'admin';
        $this->auth->shouldUse($guard);
        //未登录的，登录
        if (!$this->auth->check()) {
            if ($request->ajax()) {
                return Y::error('登录已过期，请重新登录');
            } else {
                return redirect(route('admin.login'));
            }
        }
        //检查权限
        if (!($this->auth->user()->hasRole(config('permission.super_admin')) || $this->auth->user()->can(Route::currentRouteName()))) {
            if ($request->ajax()) {
                return Y::error('您没有权限');
            }
        }
        //验证通过
        return $next($request);
    }
}
