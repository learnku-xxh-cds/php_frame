<?php

namespace core\database\query;

use core\database\connection\Connection;

class QueryBuilder
{

    protected $connection;

    protected $grammar;

    public $binds;

    public $columns;

    public $distinct;

    public $form;

    public $union;

    public $bindings = [
        'select' => [],
        'from' => [],
        'join' => [],
        'where' => [],
        'groupBy' => [],
        'having' => [],
        'order' => [],
        'union' => [],
        'unionOrder' => [],
    ];

    protected $operators = [
        '=','<','>','<=','>=','<>','!=','<=>','like','like binary','not like','ilike','&','|','^',
        '<<','>>','rlike','not rlike','regexp','not regexp','~','~*','!~','!~*','similar to','not similar to',
        'not ilike','~~*','!~~*'
    ];

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->grammar = new Grammar();
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

    public function get($columns = null)
    {
        $this->columns = $columns;
        $sql = $this->toSql();
        return $this->connection->select(
            $sql,$this->getBinds()
        );
    }

    public function toSql()
    {
        return $this->grammar->compileSelect($this);
    }

    public function getBinds()
    {
        return $this->binds;
    }








}