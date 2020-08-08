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
        $this->query->table( $this->model->getTable());
        $sql = $this->query->toSql();
        return $this->bindModel(
            $this->query->runSql($sql)
        );
    }


    // 数据映射模式 其实就把 数据映射到模型
    // 每条数据都是一个模型 !
    protected function bindModel($datas)
    {
        if(! is_array($datas))
        $datas[] = $datas;

        $models = [];
        foreach ($datas as $data){
            $model = clone $this->model; // 原型模式
            foreach ($data as $key => $val)
                $model->setOriginalValue($key, $val);
            $model->syncOriginal();
            $models[] = $model;
        }
        return $models;
    }


}
