<?php

namespace App\Core\MiddleWare;

interface MiddleWareInterface
{

    public function handle($request,\Closure $next);

}