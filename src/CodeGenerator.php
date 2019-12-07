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
        $this->view = $app['view'];
        $extensions = config('laravel-code-generator.extensions');
        foreach ($extensions as $ext) {
            $this->view->addExtension("blade.{$ext}", 'blade');
        }
        $this->files = app(Filesystem::class);
    }

    public function render(Model $model, string $template)
    {
        return $this->view->make('laravel-code-generator::' . $template, compact(['model']))->render();
    }

    public function generate(Model $model, string $template, string $outputFile = null, bool $overwrite = true)
    {
        $filepath = base_path($outputFile);
        $dirname = dirname($filepath);
        if (!file_exists($dirname)) {
            mkdir($dirname, 0755, true);
        }
        if (!file_exists($filepath) || $overwrite) {
            $result = $this->render($model, $template);
            file_put_contents($outputFile, $result);
            return $outputFile;
        } elseif ($outputFile == null) {
            $result = $this->render($model, $template);
            return $result;
        }
    }
}
