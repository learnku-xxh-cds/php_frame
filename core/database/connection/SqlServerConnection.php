<?php

namespace core\database\connection;

use core\database\Connection;
use core\database\query\QueryBuilder;
use core\query\MysqlGrammar;

class SqlServerConnection extends Connection
{



    public function __call($method, $parameters)
    {
//        return (clone new QueryBuilder($this, new SqlServerGrammer()))->$method(...$parameters);
    }

}