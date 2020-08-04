<?php

namespace core\middleware;


class IsAuthLoginMIddleware
{

    public function handle($request,\Closure $next)
    {
        if( false)
        return  "not auth";
        return $next();
    }

}