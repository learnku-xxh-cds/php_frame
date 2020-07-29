<?php

class App {

    public $binds = [];

    private static $instance;

    private function __construct()
    {
        $this->register();
        $this->boot();
    }

    public static function getApp()
    {
        if( self::$instance)
        return self::$instance;
        return self::$instance = new self();
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
        $this->bind('request', function (){
           return new \App\Core\Request();
        });
        $this->bind('response', function (){
            return new \App\Core\Response();
        });
        $this->bind('route', function (){
            return new \App\Core\RouteCollection();
        });
    }

    protected function boot()
    {
//        self::get('route')->group([
//            'namespace' => 'App\\Controller'
//        ],function ($router){
//            return FRAME_BASE_PATH.'/routes.php';
//        });
    }

}
