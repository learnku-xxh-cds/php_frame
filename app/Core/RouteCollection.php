<?php


namespace App\Core;


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


    public function addRoute($method,$uri,$uses)
    {
        $method = strtoupper($method);
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

    public function dispatch(Request $request)
    {
        $method = $request->getMethod();
        $uri = $request->getUri();
        $this->route_index = $method . $uri;
        $route = $this->getCurrRoute();
        if( $route)
        return 404;

        if( $route instanceof \Closure)
        return $route['uses']();

        $uses = explode('@',$route['uses']);
        return (new $uses[0])->$uses[1];
    }


}