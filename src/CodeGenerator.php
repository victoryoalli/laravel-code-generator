<?php

namespace VictorYoalli\LaravelCodeGenerator;

use Illuminate\Filesystem\Filesystem;
use VictorYoalli\LaravelCodeGenerator\Structure\Model;

class CodeGenerator
{
    protected $view;
    public $files;

    public function __construct()
    {
        $app = app();
        $files = app(Filesystem::class);
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
        return $result;
    }
}
