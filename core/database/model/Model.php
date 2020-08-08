<?php

namespace core\database\model;

class Model
{

    // 绑定的数据库连接
    protected $connection;

    protected $table; // 表

    protected $paimaryKey; // 主键

    protected $timestamps = true; // 是否自动维护时间字段

    public function __construct()
    {
        // 给当前模型绑定一个数据库连接
        $this->connection = \App::get('db')->connection(
            $this->connection
        );
    }


    // 获取表名称     没有表名称  就返回 模型(小写)+s
    public function getTable()
    {
        if( $this->table)
            return $this->table;

        $class_name = get_class($this);
        $class_arr = explode('\\',$class_name);

        $table = lcfirst(end(
            $class_arr
        ));

        return  $table .'s';
    }

    // 调用构造器
    public static function __callStatic($method, $args)
    {
        return  (new static())->$method(...$args);
    }

    public function __call($method, $args)
    {
        return (new Builder(
            $this->connection->newBuilder()
        ))
        ->setModel($this)
        ->$method(...$args);
    }





}