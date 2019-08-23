<?php

namespace VictorYoalli\LaravelCodeGenerator\Console;

use Illuminate\Console\Command;
use VictorYoalli\LaravelCodeGenerator\CodeGenerator;
use VictorYoalli\LaravelCodeGenerator\ModelLoader;

class GenerateCommand extends Command
{
    protected $signature = 'viento:generate {model} {--t|template=} {--o|output=resources/output} {--s|show}';

    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(ModelLoader $loader, CodeGenerator $generator)
    {
        print 'Laravel CodeGenerator' . "\n\n";

        $model = $this->argument('model');

        $template = $this->option('template');
        $output = $this->option('output');
        $show = $this->option('show');

        if ($show) {
            // $templates = $files->allFiles(config('view.paths'));
            // foreach ($templates as $key => $t) {
            //     dump($t);
            // }
        }

        if (empty($model) || empty($template)) {
            $model = empty($model) ? 'missing' : $model;
            $template = empty($template) ? '<missing>' : $template;
            print "Model: {$model}\n";
            print "Template: {$template}\n";
            print "Output: {$output}\n";
            return;
        } else {
            $m = $loader->load($model);
            $result = $generator->create($m, $template);
        }
    }
}
