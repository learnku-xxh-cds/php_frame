<?php

namespace App\Core\MiddleWare;


class HasTokenMiddleWare implements MiddleWareInterface
{

    public function handle($request,\Closure $next)
    {
        if(! $request->header('token'))
        return response('error');
        $next($request);
    }
}