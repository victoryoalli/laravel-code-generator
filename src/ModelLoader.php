<?php

namespace VictorYoalli\LaravelCodeGenerator;

use VictorYoalli\LaravelCodeGenerator\Structure\Model;

class ModelLoader
{
    private $model = null;

    public function __construct()
    {
        $this->app = app();
    }

    public function load(string $model_name, $recursive = true)
    {
        if (!class_exists($model_name)) {
            print_r("\nUnable to find '$model_name' class");
            return false;
        }

        try {
            // handle abstract classes, interfaces, ...
            $reflectionClass = new \ReflectionClass($model_name);

            if (!$reflectionClass->isSubclassOf('Illuminate\Database\Eloquent\Model')) {
                print_r("\nNot an eloquent '$model_name' class");
                return false;
            }

            if (!$reflectionClass->IsInstantiable()) {
                // ignore abstract class or interface
                return false;
            }

            $model = $this->app->make($model_name);
            $this->model = new Model($model);
            $finder = new RelationFinder();
            if ($recursive) {
                $this->model->relations = $finder->getModelRelations($model_name);
            }
        } catch (\Exception $e) {
            print_r('Exception: ' . $e->getMessage() . "\nCould not analyze class {$this->model->name}.");
        }

        return $this->model;
    }
}
