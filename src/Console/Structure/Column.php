<?php

namespace VictorYoalli\LaravelCodeGenerator\Structure;

class Column
{
    protected $column;

    public function __construct($column)
    {
        //parent::__construct();
        $this->column = $column;
    }
}
