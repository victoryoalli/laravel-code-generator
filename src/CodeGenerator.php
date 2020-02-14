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

    /**
     * Undocumented function
     *
     * @param Model $model
     * @param string $template
     * @return void
     */
    public function render(Model $model, string $template, array $options = [])
    {
        $options = (object) $options;
        return $this->view->make('laravel-code-generator::' . $template, compact(['model', 'options']))->render();
    }

    /**
     * Generates code based on your model and a template.
     * Outfile is optional. If you ommit it, the function will return the code generated as a string.
     * otherwise will return the name of the file generated.
     * You can overwrite a file if it exists setting $overwrite = true;
     * @param Model $model
     * @param string $template
     * @param string $outputFile
     * @param boolean $overwrite
     * @return void
     */
    public function generate(Model $model, string $template, string $outputFile = null, bool $overwrite = true, array $options = [])
    {
        if ($outputFile === null) {
            return $this->render($model, $template, $options);
        }
        $filepath = base_path($outputFile);
        $dirname = dirname($filepath);
        if (!file_exists($filepath) || $overwrite) {
            if (!file_exists($dirname)) {
                mkdir($dirname, 0755, true);
            }
            $result = $this->render($model, $template, $options);
            file_put_contents($outputFile, $result);
            return $outputFile;
        }
    }
}
