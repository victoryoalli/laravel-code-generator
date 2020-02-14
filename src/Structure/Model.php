<?php

namespace VictorYoalli\LaravelCodeGenerator\Structure;

use Illuminate\Database\Eloquent\Model as IlluminateModel;

class Model
{
    private $_model;
    private $_schema;
    private $_table;
    public $name;
    public $namespace;
    public $complete_name;
    public $attributes;
    public $table;
    public $relations;

    public function __construct(IlluminateModel $model)
    {
        //parent::__construct();
        $this->_model = $model;

        $this->complete_name = get_class($this->_model);
        $this->name = class_basename($this->_model);
        $this->namespace = str_replace("\\{$this->name}",'',$this->complete_name);

        $connection = $this->_model->getConnection();
        $table_name = $connection->getTablePrefix() . $this->_model->getTable();
        $this->_schema = $this->_model->getConnection()->getDoctrineSchemaManager($table_name);
        $this->table = $this->getTable($table_name);
    }

    protected function getTable(string $table_name)
    {
        $this->_table = $this->_schema->listTableDetails($table_name);
        return new Table($this->_table);
    }
}
