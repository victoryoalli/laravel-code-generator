<?php

namespace VictorYoalli\LaravelCodeGenerator;

// use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\Filesystem;
use VictorYoalli\LaravelCodeGenerator\Structure\Model;

class CodeGenerator
{
    protected $view;
    public $files;

    // public function __construct($app, Filesystem $files)
    public function __construct($app, Filesystem $files)
    {
        //parent::__construct();
        $this->view = $app['view'];
        $this->files = $files;
    }

    public function render(Model $model, string $template)
    {
        return $this->view->make('laravel-code-generator::' . $template, compact(['model']))->render();
    }

    public function create(Model $model, string $template)
    {
        $result = $this->render($model, $template);
        // print $result . "\n";
        return $result;
        // $filename = preg_replace('/\./', '/', $template);
        // $filename = preg_replace('/model/', $model->name, $filename);
        // $filename = preg_replace('/\.blade\./', '', $filename);
        // print $filename . "\n";
        // $files->put($filename, $result);
    }
}
