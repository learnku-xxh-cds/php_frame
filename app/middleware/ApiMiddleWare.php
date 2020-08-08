<?php


namespace App\middleware;


use core\Request;

class ApiMiddleWare
{
    public function handle(Request $request,\Closure $next)
    {

       // echo "api middleware";
        return $next($request);
    }
}