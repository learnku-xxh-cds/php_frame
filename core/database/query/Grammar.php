<?php

namespace core\database\query;

class Grammar
{

    protected $operators = [];
    protected $selectComponents = [
        'aggregate',
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

    // TODO 
    public function compileSelect(QueryBuilder $query)
    {

        $original = $query->columns;
        if ( is_null( $query->columns))
        $query->columns = ['*'];

    }

}
