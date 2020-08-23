<?php

namespace core\database;


use core\database\connection\MysqlConnection;

class Database
{
    protected $connections = []; // all connection

    protected function getDefaultConnection()
    {
        return \App::getContainer()->get('config')->get('database.default');
    }


    public function supportedDrivers()
    {
        return ['mysql', 'pgsql', 'sqlite', 'sqlsrv'];
    }

    public function setDefaultConnection($name)
    {
        \App::getContainer()->get('config')->set('database.default', $name);
    }

    public function connection($name = null)
    {

        if( isset($this->connections[$name]))
            return $this->connections[$name];

        if( $name == null)
            $name = $this->getDefaultConnection();

        $config = \App::getContainer()->get('config')->get('database.connections.'.$name);

        $connectionClass = null; // handle connection class

        switch ($config['driver']) {
            case 'mysql': $connectionClass = MysqlConnection::class; break;
        }
        $dsn = sprintf('%s:host=%s;dbname=%s',$config['driver'], $config['host'], $config['dbname']);
        try {
            $pdo = new \PDO($dsn, $config['username'], $config['password'],$config['options']);
        }catch (\PDOException $e) {
             die($e->getMessage());
        }

        return $this->connections[$name] = new $connectionClass($pdo,$config);
    }


    // proxy
    public function __call($method, $parameters)
    {
        return $this->connection()->$method(...$parameters);
    }

}