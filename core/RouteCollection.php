<?php

namespace core;


use core\request\RequestInterface;

Class RouteCollection
{

    protected $routes = [];

    protected $route_index = 0;
    public function getRoutes()
    {
        return $this->routes;
    }

    public $currGroup = [];
    public function group($attributes = [],\Closure $callback)
    {
        $this->currGroup[] = $attributes;

        call_user_func($callback,$this);
        // $callback($this);  跟这个一样的效果
       // group的实现主要的这个$this  这个$this将当前状态传递到了闭包

        array_pop($this->currGroup);
    }


    // 增加/  如: GETUSER 改成 GET/USER
    protected function addSlash(& $uri)
    {
        return $uri[0] == '/' ? : $uri = '/'.$uri;
    }


    // 增加路由
    public function addRoute($method,$uri,$uses)
    {

        $prefix = '';
        $middleware = [];
        $namespace = '';
        $this->addSlash($uri);
        foreach ($this->currGroup as $group){
            $prefix .= $group['prefix'] ?? false;
            if( $prefix)
              $this->addSlash($prefix);

            if( isset($group['middleware'])) // $middleware要是个数组
                if( is_array($group['middleware']))
                    $middleware = $group['middleware'];
                else
                    $middleware[] = $group['middleware'];

            $namespace .= $group['namespace']??'';
        }
        $method = strtoupper($method); // 请求方式
        $uri = $prefix .$uri;
        $this->route_index = $method . $uri; // 路由索引
        $this->routes[$this->route_index] = [
            'method' => $method,
            'uri' => $uri,
            'action' => [
              'uses' => $uses,
              'middleware' => $middleware,
              'namespace' => $namespace
          ]
        ];
    }


    public function get($uri,$uses)
    {
        $this->addRoute('get',$uri,$uses);
        return $this;
    }


    public function post($uri,$uses)
    {
        $this->addRoute('post',$uri,$uses);
        return $this;
    }



    public function middleware($class)
    {
         $this->routes[$this->route_index]['action']['middleware'][] = $class;
         return $this;
    }

    public function getCurrRoute()
    {
        $routes = $this->getRoutes();
        $route_index = $this->route_index;
        // $str_count = strlen($this->route_index);

        if( isset( $routes[ $route_index]))
            return  $routes[ $route_index];

        $route_index .= '/';

        if( isset( $routes[ $route_index]))
          return  $routes[ $route_index];
        return  false;
    }


    // 更具request执行路由
    public function dispatch($request)
    {

        $method = $request->getMethod();
        $uri = $request->getUri();
        $this->route_index = $method . $uri;

        $route = $this->getCurrRoute();
        if(! $route)
        return 404;

        $routerDispatch = $route['action']['uses'];
        $middleware = $route['action']['middleware'] ?? [];

        if(! $route['action']['uses'] instanceof \Closure){ // 不是闭包 就是控制器了
            $action = $route['action'];
            $uses = explode('@',$action['uses']);
            $controller = $action['namespace'].'\\'.$uses[0]; // 控制器
            $method = $uses[1]; // 执行的方法
            $controllerInstance = new $controller;
            $middleware = array_merge($middleware,$controllerInstance->getMiddleware()); // 合并控制器中间件
            $routerDispatch = function ($request) use($route, $controllerInstance, $method){
                return $controllerInstance->callAction($method,[ $request ]);
            };
        }

        return \App::getContainer()->get('pipeline')->create()->setClass(
            $middleware
        )->run($routerDispatch)(
            \App::getContainer()->get(RequestInterface::class)
        );
    }


}