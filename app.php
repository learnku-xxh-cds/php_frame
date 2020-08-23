<?php


define('FRAME_BASE_PATH', __DIR__);
define('FRAME_START_TIME', microtime(true));
define('FRAME_START_MEMORY',memory_get_usage());

class App {

    // ioc见: https://learnku.com/docs/laravel-core-concept/5.5/Ioc%E5%AE%B9%E5%99%A8,%E6%9C%8D%E5%8A%A1%E6%8F%90%E4%BE%9B%E8%80%85/3019

    public $binding = [];
    private  static $instance; // app示例
    protected $instances = []; // 所有已经实例化的实例 单例
    protected  $regisers = [
        \core\request\RequestInterface::class => \core\request\PhpRequest::class,
//        \core\request\RequestInterface::class => \core\request\SwooleRequest::class, 切换成swoole的

        'config' => \core\Config::class,
        'response' => \core\Response::class,
        'route' => \core\RouteCollection::class,
        'pipeline' => \core\PipleLine::class,
        'db' => \core\database\connection\Connection::class,
        'exception' => \App\exceptions\HandleExceptions::class,
        \core\view\ViewInterface::class => \core\view\Blade::class
    ];

    public function __construct()
    {
        self::$instance = $this;
        $this->register();
        $this->boot();
    }

    public  function get($abstract)
    {
        if( isset($this->instances[$abstract])) // 如果此服务有实例
            return $this->instances[$abstract];

        $instance = $this->binding[$abstract]['concrete']($this);
        if( $this->binding[$abstract]['is_singleton']) // 如果是单例 就缓存起来
            $this->instances[$abstract] = $instance;

        return $instance;
    }


    public static function getContainer()
    {
        return self::$instance ?? self::$instance = new self();
    }

    // $is_singleton是否是单例
    public function bind($abstract, $concrete,$is_singleton = false)
    {
        $concrete = function ($app) use ($concrete) {
            return $app->build($concrete);
        };
        $this->binding[$abstract] = compact('concrete','is_singleton');
    }

    // 获取参数的依赖
    protected function getDependencies($paramters) {
        $dependencies = [];
        foreach ($paramters as $paramter)
            if( $paramter->getClass())
            $dependencies[] = $this->get($paramter->getClass()->name);
        return $dependencies;
    }

    public function build($concrete) {
        $reflector = new ReflectionClass($concrete);
        $constructor = $reflector->getConstructor();
        if( is_null($constructor))
            return $reflector->newInstance();

        $dependencies = $constructor->getParameters();
        $instances = $this->getDependencies($dependencies);
        return $reflector->newInstanceArgs($instances);
    }

    protected function register()
    {
        foreach ($this->regisers as $name => $concrete)
            $this->bind($name, $concrete, true);
    }

    protected function boot()
    {
        $this->get('config')->init(); // 配置加载
        $this->get(\core\view\ViewInterface::class)->init(); // 模板引擎初始化
   //     $this->get('exception')->init(); // 异常托管
//        var_dump( $_SERVER);exit;
        $this->get(\core\request\RequestInterface::class)::init();
        //web router
        self::get('route')->group([
            'namespace' => 'App\\controller',
            'middleware' => [
                \App\middleware\WebMiddleWare::class
            ]
        ],function ($router){
            require_once FRAME_BASE_PATH . '/routes/web.php';
        });

        //api router
        self::get('route')->group([
            'namespace' => 'App\\Controller\\Api',
            'prefix' => 'api',
            'middleware' => [
                \App\middleware\WebMiddleWare::class
            ]
        ],function ($router){
            require_once FRAME_BASE_PATH . '/routes/api.php';
        });

    }

}
