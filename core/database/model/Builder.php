<?php

namespace core\database\model;

class Builder
{

    protected $query;
    protected $model;
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this;
    }

    public function __call($method, $args)
    {
        $this->query->$method(...$args);
        return $this;
    }

    public function get($columns = ['*'])
    {
        if(! is_array($columns))
            $columns  = func_get_args();

        $this->query->columns = $columns;
        $sql = $this->query->toSql();
        $res = $this->query->runSql($sql);
        var_dump($res);exit;
    }

}
