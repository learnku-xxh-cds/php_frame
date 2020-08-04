<?php

namespace core\database\query;

use core\database\connection\Connection;
use Illuminate\Support\Arr;

class Builder
{

    protected $connection;

    protected $grammar;

    protected $binds;

    protected $columns;

    protected $distinct;

    protected $form;

    protected $operators = [
        '=','<','>','<=','>=','<>','!=','<=>','like','like binary','not like','ilike','&','|','^',
        '<<','>>','rlike','not rlike','regexp','not regexp','~','~*','!~','!~*','similar to','not similar to',
        'not ilike','~~*','!~~*'
    ];


    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function table(string $table,$as = null)
    {
        return (clone $this)->from($table,$as);
    }

    public function from($table,$as)
    {
        $this->from = $as ? "{$table} as {$as}" : $table;
        return $this;
    }

    public function get($columns = [' * '])
    {
        return collect($this->onceWithColumns(Arr::wrap($columns), function () {
            return $this->processor->processSelect($this, $this->runSelect());
        }));
    }


    protected function runSelect()
    {
        return $this->connection->select(
            $this->toSql(), $this->getBindings(), ! $this->useWritePdo
        );
    }

    public function toSql()
    {
        return $this->grammar->compileSelect($this);
    }





}