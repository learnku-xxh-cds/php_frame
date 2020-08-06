<?php

namespace core\database\query;

class Grammar
{

    protected $operators = [];
    protected $selectComponents = [
        'columns',
        'from',
        'joins',
        'wheres',
        'groups',
        'havings',
        'orders',
        'limit',
        'offset',
        'lock',
    ];


    public function compileSql(QueryBuilder $query)
    {
        $sql = [];
        foreach ($this->selectComponents as $component)
            if( isset( $query->{$component}))
                $sql[$component] = $this->$component($query, $query->$component);

        return implode($sql);
    }


    protected function columns(QueryBuilder $query,$columns)
    {
        if(! $columns)
        $columns = ['*'];

        $select = 'select ';
        if ($query->distinct)
            $select = 'select distinct ';

        return $select . implode(',',$columns);
    }

    protected function from(QueryBuilder $query,$form)
    {
        return ' from '.$form;
    }

    protected function joins()
    {

    }

    protected function wheres(QueryBuilder $queryBuilder,$wheres)
    {
        if(! $wheres)
        return '';

        $where_arrs = [];
        foreach ($wheres as $index => $where){
            if(! $index)
            $where['joiner'] = ' where';

            $where_arrs[] =  sprintf(' %s `%s` %s ?',$where['joiner'], $where['column'], $where['operator']);
        }
        return implode($where_arrs);
     }

    protected function groups()
    {

    }

    protected function havings()
    {

    }

    protected function orders()
    {

    }

    protected function limit()
    {

    }

    protected function offset()
    {

    }

    protected function lock()
    {

    }

}
