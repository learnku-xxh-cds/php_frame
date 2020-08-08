<?php

namespace core;

class PipleLine
{

    // 所有要执行的类
    protected $classes = [];

    // 类的方法名称
    protected $handleMethod = 'handle';

    // 因为容器的单例的,所以要创建一个新的 对象
    public function create()
    {
        return clone $this;
    }

    // 没啥用  但是遵守原则而已
    public function setHandleMethod($method)
    {
        $this->handleMethod = $method;
        return $this;
    }

    public function setClass($class)
    {
        $this->classes = $class;
        return $this;
    }

    // 传递闭包 运行管道
    // 这个代码过于抽象 学习文章: https://segmentfault.com/a/1190000017792800
    public function run(\Closure $initial)
    {
        return array_reduce( array_reverse($this->classes),function($res, $currClass){
            return function ($request) use ($res,$currClass) {
                return (new $currClass)->{$this->handleMethod}($request,$res);
            };
        },$initial);
    }



}