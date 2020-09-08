<?php


define('FRAME_BASE_PATH', __DIR__); // 框架目录
define('FRAME_START_TIME', microtime(true)); // 开始时间
define('FRAME_START_MEMORY',memory_get_usage()); // 开始内存


// 对于psr规范... 呃呃 看个人爱好吧
class App implements Psr\Container\ContainerInterface {

    // ioc见: https://learnku.com/docs/laravel-core-concept/5.5/Ioc%E5%AE%B9%E5%99%A8,%E6%9C%8D%E5%8A%A1%E6%8F%90%E4%BE%9B%E8%80%85/3019

    public $binding = []; // 绑定关系
    private  static $instance; // App类的实例
    protected $instances = []; // 所有实例的存放

    private function __construct()
    {
        self::$instance = $this; // App类的实例
        $this->register();  // 注册绑定
        $this->boot(); // 服务注册了 才能启动
    }


    public  function get($abstract)
    {

        if( isset($this->instances[$abstract])) // 此服务已经实例化过了
            return $this->instances[$abstract];

        $instance = $this->binding[$abstract]['concrete']($this); // 因为服务是闭包 加()就可以执行了
        if( $this->binding[$abstract]['is_singleton']) // 设置为单例
            $this->instances[$abstract] = $instance;

        return $instance;
    }

    // 是否有此服务
    public function has($id)
    {

    }

    // 当前的App实例  单例
    public static function getContainer()
    {
        return self::$instance ?? self::$instance = new self();
    }

    /**
     *@param string $abstract 就是key
     *@param void|string $concrete 就是value
     *@param  boolean $is_singleton 这个服务要不要变成单例
     */
    public function bind($abstract, $concrete,$is_singleton = false)
    {
        if(! $concrete instanceof  \Closure) // 如果具体实现不是闭包  那就生成闭包
            $concrete = function ($app) use ($concrete) {
                return $app->build($concrete);
            };
        $this->binding[$abstract] = compact('concrete','is_singleton'); // 存到$binding大数组里面
    }


    protected function getDependencies($paramters) {
        $dependencies = []; // 当前类的所有依赖
        foreach ($paramters as $paramter)
            if( $paramter->getClass())
                $dependencies[] = $this->get($paramter->getClass()->name);
        return $dependencies;
    }


    // 解析依赖
    public function build($concrete) {
        $reflector = new ReflectionClass($concrete); // 反射
        $constructor = $reflector->getConstructor(); // 获取构造函数
        if( is_null($constructor))
            return $reflector->newInstance(); // 没有构造函数？ 那就是没有依赖 直接返回实例

        $dependencies = $constructor->getParameters(); // 获取构造函数的参数
        $instances = $this->getDependencies($dependencies);  // 当前类的所有实例化的依赖
        return $reflector->newInstanceArgs($instances); // 跟new 类($instances); 一样了
    }

    protected function register()
    {
        // 先注册配置 后续服务可能会依赖配置
        $this->bind('config',\core\Config::class,true);
        $this->get('config')->init(); // 配置加载


        $registers = [
            'response' => \core\Response::class,
            'route' => \core\RouteCollection::class,
            'pipeline' => \core\PipleLine::class,
            'db' => \core\database\Database::class,
            //'db' => \core\database\connection\Connection::class,
            'exception' => \App\exceptions\HandleExceptions::class,
            \core\view\ViewInterface::class => \core\view\Blade::class,
            'log'   => \core\log\Logger::class
        ];

        foreach ($registers as $name => $concrete)
            $this->bind($name, $concrete, true);


    }

    protected function boot()
    {

        $this->get(\core\view\ViewInterface::class)->init(); // 模板引擎初始化
        $this->get('exception')->init(); // 异常托管

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
