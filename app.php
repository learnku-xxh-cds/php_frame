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
        return self::$binds[$name]['instance']
            ?? self::$binds[$name]['instance'] = (self::$binds[$name]['concrete'])();
    }

    public function bind($name,$concrete)
    {
        self::$binds[$name]['concrete'] = $concrete;
    }

    protected function register()
    {
        $this->bind('config', function (){
            return new \core\Config();
        });


        //用闭包原因: 在没调用之前只是字符串 调用才new
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

        $this->bind('db', function (){
            return new \core\database\Database();
        });

        $this->bind('view',function (){
            return new \core\view\View();
        });

    }

    protected function boot()
    {
        //web router
        self::get('route')->group([
            'namespace' => 'App\\controller',
            'middleware' => [
                \App\middleware\WebMiddleWare::class
            ]
        ],function ($router){
            require_once FRAME_BASE_PATH . 'routes/web.php';
        });

        //api router
        self::get('route')->group([
            'namespace' => 'App\\Controller\\Api',
            'prefix' => 'api',
            'middleware' => [
                \App\middleware\WebMiddleWare::class
            ]
        ],function ($router){
            require_once FRAME_BASE_PATH . 'routes/api.php';
        });

        self::get('config')->init();
        self::get('view')->init();
    }

}

new App();