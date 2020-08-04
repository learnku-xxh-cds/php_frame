<?php

class App {

    protected  static $binds = [];

    public function __construct()
    {
        $this->register();
        $this->boot();
    }

    public static function get($name)
    {
        if( isset( self::$binds[$name]['instance']))
            return self::$binds[$name]['instance'];

        return self::$binds[$name]['instance'] = (self::$binds[$name]['concrete'])();
    }

    public function bind($name,$concrete)
    {
        self::$binds[$name]['concrete'] = $concrete;
    }

    protected function register()
    {
        $this->bind('request', function (){
            return new \core\Request();
        });
        $this->bind('response', function (){
            return new \core\Response();
        });
        $this->bind('route', function (){
            return new \core\RouteCollection();
        });
        $this->bind('pipeline', function (){
            return new \core\PipleLine();
        });
        $this->bind('config', function (){
            return new \core\Config();
        });
        $this->bind('db', function (){
            return new \core\database\Database();
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
        self::get('config')->init();
    }

}

new App();