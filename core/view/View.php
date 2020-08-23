<?php

namespace core\view;

class View
{

    protected $engin;

    //ViewInterface
    public function __construct(ViewInterface $engin)
    {
        $this->engin = $engin;
        $this->engin->init();
    }

    public function __call($method, $args)
    {
        return  $this->engin->$method(...$args);
    }
}