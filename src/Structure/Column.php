<?php

namespace VictorYoalli\LaravelCodeGenerator\Structure;

use Doctrine\DBAL\Types\Type;

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
        $this->_column = $column;
        $this->name = $this->_column->getName();
        $this->type = $this->getTypeString($this->_column->getType());
        $this->length = $this->_column->getLength();
        $this->nullable = !$this->_column->getNotNull();
        $this->autoincrement = $this->_column->getAutoincrement();
        $this->default = $this->_column->getDefault();
    }
    private function getTypeString(string|Type $type)
    {
        return is_object($type)?preg_replace(
            "/Doctrine\\\\DBAL\\\\Types\\\\([a-zA-B]+)Type/i",
            '$1',
            get_class($type)
        ):str_replace("\\", "", $type);
    }
}
