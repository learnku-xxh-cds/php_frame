<?php

class App {

    public $binds = [];


    public function __construct()
    {
        $this->register();
    }

    public function get($name)
    {
        return $this->binds[$name]();
    }

    public function bind($name,$concrete)
    {
        $this->binds[$name] = $concrete;
    }

    protected function register()
    {
        $this->bind('request',function (){
           return new \App\Core\Request();
        });
    }

}

return new App();