<?php

namespace VictorYoalli\LaravelCodeGenerator\Structure;

class Table
{
    protected $table;
    public $name;
    private $_columns;
    public $columns;

    public function __construct($table)
    {
        //parent::__construct();
        $this->table = $table;
        $this->name = $this->table->getName();
        $this->columns = $this->getColumns();
    }

    public function getColumns()
    {
        $cols = $this->table->getColumns();
        foreach ($cols as $key => $col) {
            $columns[] = new Column($col);
        }
        return $columns;
    }
}
