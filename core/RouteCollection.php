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

    public function dispatch($request)
    {

        $method = $request->getMethod();
        $uri = $request->getUri();
        $this->route_index = $method . $uri;

        $route = $this->getCurrRoute();
        if(! $route)
        return 404;

        $routerDispatch = $route['action']['uses'];
        if(! $route['action']['uses'] instanceof \Closure)
          $routerDispatch = function ($route) {
            $uses = explode('@',$route['uses']);
            return (new $uses[0])->$uses[1];
           };

        return \App::getApp()->get('pipeline')->create()->setClass(
            $route['action']['middleware'] ?? []
        )->run($routerDispatch)(
            \App::getApp()->get('request')
        );
    }


}