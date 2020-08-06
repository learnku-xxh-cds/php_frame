<?php


namespace core\database\connection;

use core\database\query\MysqlGrammar;
use core\database\query\QueryBuilder;

class MysqlConnection extends Connection
{

    protected static $connection;

    public function getConnection()
    {
        return self::$connection;
    }

    public function select($sql, $bindings = [], $useReadPdo = true)
    {
        $statement = $this->pdo;
        $sth = $statement->prepare($sql);

        try {
           $sth->execute( $bindings);
           return  $sth->fetchAll();
         } catch (\PDOException $exception){
            echo ($exception->getMessage());
        }

    }


    protected function bindValues()
    {
        return [];
    }

    protected function run($query, $bindings, Closure $callback)
    {
        try {
            $result = $this->runQueryCallback($query, $bindings, $callback);
        } catch (QueryException $e) {
            $result = $this->handleQueryException(
                $e, $query, $bindings, $callback
            );
        }
        $this->logQuery(
            $query, $bindings, $this->getElapsedTime($start)
        );
        return $result;
    }


    public function __call($method, $parameters)
    {
        return (clone new QueryBuilder($this, new MysqlGrammar()))->$method(...$parameters);
    }


}