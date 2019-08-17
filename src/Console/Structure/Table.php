<?php

namespace VictorYoalli\LaravelCodeGenerator\Structure;

class Table
{
    protected $table;
    public $columns = [];

    public function __construct($table)
    {
        //parent::__construct();
        $this->table = $table;
    }

    public function columns()
    {
        return $this->table->getColumns();
    }
}
