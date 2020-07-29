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
        return self::$instance ? : self::$instance = new self();
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

        //web router
        self::get('route')->group([
            'namespace' => 'App\\Controller'
        ],function ($router){
            //var_dump($router);exit;
            require_once FRAME_BASE_PATH . 'routes/web.php';
        });


        //api router
        self::get('route')->group([
            'namespace' => 'App\\Controller\\Api',
            'prefix' => 'api'
        ],function ($router){
            require_once FRAME_BASE_PATH . 'routes/api.php';
        });
    }

}
