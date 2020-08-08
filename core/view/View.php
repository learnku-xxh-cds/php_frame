<?php

namespace core\view;

class View
{

    protected $engin;


    public function init()
    {
        $engin = \App::get('config')->get('view.engine');
        $this->engin = new $engin();
        $this->engin->init();
    }

    public function __call($method, $args)
    {
        return  $this->engin->$method(...$args);
    }
}