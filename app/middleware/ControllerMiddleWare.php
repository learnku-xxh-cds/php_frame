<?php

namespace App\middleware;


use core\Request;

class ControllerMiddleWare
{

    public function handle(Request $request,\Closure $next)
    {

         echo "调用控制器中间件";
        return $next($request);
    }
}