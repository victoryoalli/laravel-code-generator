<?php

namespace VictorYoalli\LaravelCodeGenerator\Structure;

class Table
{
    protected $table;
    public $name;
    public $columns;

    public function __construct($table)
    {
        $this->table = $table;
        $this->name = $this->table->getName();
        $this->columns = $this->getColumns();
    }

    public function getColumns()
    {
        $cols = $this->table->getColumns();
        foreach ($cols as $col) {
            $columns[] = new Column($col);
        }
        return $columns;
    }
}
