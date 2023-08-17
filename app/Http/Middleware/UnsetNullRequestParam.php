<?php


namespace App\Http\Middleware;


use Illuminate\Http\Request;

class UnsetNullRequestParam
{
    public function handle(Request $request, \Closure $next)
    {
        $parameter = collect($request)->filter(function ($request) {
            return !is_null($request);
        })->toArray();
        $request->replace($parameter);
        return $next($request);
    }
}