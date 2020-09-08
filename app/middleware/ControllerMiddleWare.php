<?php

namespace App\middleware;


use core\Request;
use core\request\RequestInterface;

class ControllerMiddleWare
{

    public function handle(RequestInterface $request,\Closure $next)
    {

         echo "调用控制器中间件";
        return $next($request);
    }
}