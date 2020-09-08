<?php


namespace App\middleware;


use core\request\RequestInterface;

class ApiMiddleWare
{
    public function handle(RequestInterface $request,\Closure $next)
    {

       // echo "api middleware";
        return $next($request);
    }
}