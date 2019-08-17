<?php

namespace VictorYoalli\LaravelCodeGenerator\Structure;

use Illuminate\Support\Str;

class Model
{
    protected $app;
    protected $model_name;
    protected $_model;
    protected $_table;
    protected $_columns;

    public $table;

    public function __construct($app, $model_name)
    {
        //parent::__construct();
        $this->app = $app;
        $this->model_name = $model_name;
        $this->_model = $this->loadModelInfo($this->model_name);
        // $this->_table = $this->_model->table;
        $this->_table = $this->loadTableInfo($this->_model);
        $this->table = new Table($this->_table);
        // $this->_columns = $this->_table->getColumns();
        $this->columns = $this->table->columns();
        $this->columns = $this->table->columns;
    }

    protected function loadModelInfo($model_name)
    {
        if (!class_exists($model_name)) {
            print_r("Unable to find '$model_name' class");
            return false;
        }

        $model = null;

        try {
            // handle abstract classes, interfaces, ...
            $reflectionClass = new \ReflectionClass($model_name);

            if (!$reflectionClass->isSubclassOf('Illuminate\Database\Eloquent\Model')) {
                return false;
            }

            if (!$reflectionClass->IsInstantiable()) {
                // ignore abstract class or interface
                return false;
            }

            $model = $this->app->make($model_name);

            // $this->_table = $this->loadTableInfo($model);
            // $this->getPropertiesFromMethods($model);
        } catch (\Exception $e) {
            print_r('Exception: ' . $e->getMessage() . "\nCould not analyze class $model.");
        }

        return $model;
    }

    protected function loadTableInfo($model)
    {
        $table_name = $model->getConnection()->getTablePrefix() . $model->getTable();
        $schema = $model->getConnection()->getDoctrineSchemaManager($table_name);
        return $schema->listTableDetails($table_name);

        $databasePlatform = $schema->getDatabasePlatform();
        $databasePlatform->registerDoctrineTypeMapping('enum', 'string');
        // dump($table_name);
        // dump($schema);
        // dump($databasePlatform);

        $platformName = $databasePlatform->getName();
        // dump($platformName);
        $customTypes = $this->app['config']->get("ide-helper.custom_db_types.{$platformName}", []);
        foreach ($customTypes as $yourTypeName => $doctrineTypeName) {
            $databasePlatform->registerDoctrineTypeMapping($yourTypeName, $doctrineTypeName);
        }
        // dump($customTypes);

        $database = null;
        if (strpos($table_name, '.')) {
            list($database, $table_name) = explode('.', $table_name);
        }
        // dump($database);

        return $schema->listTableDetails($table_name);
        // dump($table);
        // $columns = $schema->listTableColumns($table_name, $database);

        // dump($columns);
        /*
        foreach ($this->columns as $key => $column) {
            print "name: {$column->getName()}\n";
            // print "short name: {$column->getShortestName()}\n";
            print "type: {$column->getType()}\n";
            print "length: {$column->getLength()}\n";
            print "scale: {$column->getScale()}\n";
            print "default: {$column->getDefault()}\n";
            print "not null: {$column->getNotNull()}\n";
            print "unsigned: {$column->getUnsigned()}\n";
            print "precision: {$column->getPrecision()}\n";
            print "auto_increment: {$column->getAutoIncrement()}\n";
            print Str::camel($column->getName()) . "\n";
            print "---\n";
        }

        $methods = get_class_methods($model);
        print "----- \n";
        foreach ($methods as $key => $method) {
            if (!method_exists('Illuminate\Database\Eloquent\Model', $method) && Str::startsWith($method, 'get')) {
                print($method) . "\n";
            }
        }
        */

        /*
        if ($columns) {
            foreach ($columns as $column) {
                $name = $column->getName();
                if (in_array($name, $model->getDates())) {
                    $type = 'datetime';
                } else {
                    $type = $column->getType()->getName();
                }
                if (!($model->incrementing && $model->getKeyName() === $name) &&
                    $name !== $model::CREATED_AT &&
                    $name !== $model::UPDATED_AT
                ) {
                    if (!method_exists($model, 'getDeletedAtColumn') || (method_exists($model, 'getDeletedAtColumn') && $name !== $model->getDeletedAtColumn())) {
                        $this->setProperty($name, $type);
                    }
                }
            }
        }
        */
    }
}
