<?php

namespace VictorYoalli\LaravelCodeGenerator\Structure;

class Column
{
    protected $_column;
    public $name ;
    public $type ;
    public $length ;
    public $nullable ;
    public $autoincrement ;
    public $default ;

    public function __construct($column)
    {
        //parent::__construct();
        $this->_column = $column;
        $this->name = $this->_column->getName();
        $this->type = str_replace("\\","",$this->_column->getType());
        $this->length = $this->_column->getLength();
        $this->nullable = !$this->_column->getNotNull();
        $this->autoincrement = $this->_column->getAutoincrement();
        $this->default = $this->_column->getDefault();
    }
}
