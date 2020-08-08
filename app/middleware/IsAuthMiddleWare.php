<?php

namespace App\Middleware;

class IsAuthMiddleWare
{
    public function handle($request,\Closure $next)
    {
        if( false)
            return '未登录';
        return $next($request);
    }

}