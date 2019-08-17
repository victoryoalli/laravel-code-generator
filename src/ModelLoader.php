<?php

namespace VictorYoalli\LaravelCodeGenerator;

class ModelLoader
{
    private $model = null;
    private $table = null;
    private $columns = null;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function load(string $model_name)
    {
        if (!class_exists($model_name)) {
            print_r("Unable to find '$model_name' class");
            return false;
        }

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

            $this->model = $this->app->make($model_name);
        } catch (\Exception $e) {
            print_r('Exception: ' . $e->getMessage() . "\nCould not analyze class $this->model.");
        }

        return $this->model;
    }
}
