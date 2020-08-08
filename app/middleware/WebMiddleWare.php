<?php

namespace App\middleware;


use core\Request;

class WebMiddleWare
{
    public function handle($request,\Closure $next)
    {
       // echo "web middleware";
        return $next($request);
    }

}