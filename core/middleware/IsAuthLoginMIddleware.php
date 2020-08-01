<?php

namespace core\middleware;


class IsAuthLoginMIddleware
{

    public function handle($request,\Closure $next)
    {
        echo "is_auth_login_middleawre".PHP_EOL;
        return $next();
    }

}