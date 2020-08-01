<?php

namespace core;


use Cassandra\Varint;

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
        $callback($this);
//        call_user_func($callback,$this);
        array_pop($this->currGroup);
    }

    protected function addSlash(& $uri)
    {
        return $uri[0] == '/' ? : $uri = '/'.$uri;
    }

    public function addRoute($method,$uri,$uses)
    {

        $prefix = '';
        $middleware = [];
        $this->addSlash($uri);
        foreach ($this->currGroup as $group){
            $prefix .= $group['prefix'] ?? false;
            if( $prefix)
              $this->addSlash($prefix);

            if( isset($group['middleware']))
              $middleware[] = $group['middleware'];
        }

        $method = strtoupper($method);
        $uri = $prefix .$uri;

        $this->route_index = $method . $uri;
        $this->routes[$this->route_index] = [
          'method' => $method,
          'uri' => $uri,
          'action' => [
              'uses' => $uses
          ]
        ];
    }


    public function get($uri,$uses)
    {
        $this->addRoute('get',$uri,$uses);
        return $this;
    }

    public function middleware($class)
    {
         $this->routes[$this->route_index]['action']['middleware'][] = $class;
         return $this;
    }

    public function getCurrRoute()
    {
        return $this->getRoutes()[$this->route_index] ?? false;
    }

    public function dispatch($request)
    {

        $method = $request->getMethod();
        $uri = $request->getUri();
        $this->route_index = $method . $uri;

        $route = $this->getCurrRoute();
        if(! $route)
        return 404;


        $middlewares = $route['action']['middleware'];

        if( $route['action']['uses'] instanceof \Closure){
            $routerDispatch = $route['action']['uses'];
        } else{
            $routerDispatch = function ($route) {
                $uses = explode('@',$route['uses']);
                (new $uses[0])->$uses[1];
            };
        }

        return \App::getApp()->get('pipeline')->create()->setClass(
            $middlewares
        )->run($routerDispatch)(
            \App::getApp()->get('request')
        );
    }


}