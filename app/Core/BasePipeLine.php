<?php

namespace App\Core;

class BasePipeLine
{


    protected $method = 'handle';

    protected $passable;

    protected $pipes = [];

    public function send($passable)
    {
        $this->passable = $passable;
        return $this;
    }

    public function through($pipes)
    {
        $this->pipes = $pipes;
        return $this;
    }

    public function then(\Closure $destination)
    {
        $pipeline = array_reduce(array_reverse($this->pipes), $this->getSlice(), $destination);
        return $pipeline($this->passable);
    }



    protected function getSlice()
    {
        return function($stack, $pipe){
            return function ($request) use ($stack, $pipe) {
                return $pipe::{$this->method}($request, $stack);
            };
        };
    }

}

