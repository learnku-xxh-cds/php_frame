<?php

namespace core\database\model;


use core\database\query\QueryBuilder;

class Model
{

    protected $connection;

    protected $table;

    protected $paimaryKey;

    protected $timestamps = true;

    public function __construct()
    {
        $this->connection = \App::get('db')->connection(
            $this->connection
        );
    }


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


    public static function __callStatic($method, $args)
    {
        return  (new static())->$method(...$args);
    }


}