<?php

namespace VictorYoalli\LaravelCodeGenerator\Console;

use Illuminate\Console\Command;
use VictorYoalli\LaravelCodeGenerator\CodeGenerator;
use VictorYoalli\LaravelCodeGenerator\Helper;
use VictorYoalli\LaravelCodeGenerator\ModelLoader;

class GenerateCommand extends Command
{
    protected $signature = 'code:generate {model} {--t|template=} {--m|map=map.php : Map file}';

    protected $description = 'A Laravel Code Generator based on your Models.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(ModelLoader $loader, CodeGenerator $generator)
    {
        $model = $this->argument('model');

        $template = $this->option('template');

        if (empty($model)) {
            return;
        }
        $m = $loader->load($model);

        if (empty($template)) {
            $template = empty($template) ? '<missing>' : $template;
            print "Template: {$template}\n";
            return;
        } else {
            $result = $generator->generate($m, $template);
            print $result . "\n";
        }
    }

    protected static function getTemplateName($filename)
    {
        return preg_replace('/\.blade.*$/', '', $filename);
    }

    protected static function newFilename($model_name, $filename)
    {
        print 'filename:::: ' . Helper::slug($model_name) . "\n";
        $result = preg_replace('/\.blade\./', '', $filename);
        $result = preg_replace('/\.model\./', '', $model_name);
        return $result;
    }
}
