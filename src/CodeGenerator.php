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
        if (!$this->files->exists($filepath) || $overwrite) {
            $this->files->ensureDirectoryExists(dirname($filepath), null, true);
            $result = $this->render($model, $template, $options);
            $this->files->put($outputFile, $result);
            return $outputFile;
        }

        return null;
    }

    public function copy(string $inputPath, string $outputPath, bool $overwrite = false)
    {
        $inputPath = resource_path('views/vendor/laravel-code-generator/'.$inputPath);
        $outputPath = base_path($outputPath);
        if (!$this->files->exists($inputPath)) {
            throw new \Exception("File $inputPath does not exist.");
        }

        $this->files->ensureDirectoryExists(dirname($outputPath));
        dump($inputPath);
        dump($outputPath);
        if (!$this->files->exists($outputPath) && $this->files->isDirectory($outputPath)   || $overwrite) {
            print "Copying $inputPath to $outputPath\n";
            $this->files->copyDirectory($inputPath, $outputPath);
            $files = collect($this->files->files($inputPath));
            dd($files);

            return $outputPath;
        } elseif ($this->files->isFile($outputPath) && !$this->files->exists($outputPath) || $overwrite) {
            $this->files->copy($inputPath, $outputPath);
            return $outputPath;
        }
        return null;
    }
}
