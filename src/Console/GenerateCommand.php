<?php

namespace VictorYoalli\LaravelCodeGenerator\Console;

use Illuminate\Console\Command;
use VictorYoalli\LaravelCodeGenerator\CodeGenerator;
use VictorYoalli\LaravelCodeGenerator\ModelLoader;

class GenerateCommand extends Command
{
    protected $signature = 'code:generate {model} {--t|template= : template location} {--f|outfile= : Output file location}';

    protected $description = 'A Laravel Code Generator based on your Models.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(ModelLoader $loader, CodeGenerator $generator)
    {
        $model = $this->argument('model');

        $template = $this->option('template');
        $outputFile = $this->option('outfile');

        if (empty($model)) {
            return;
        }
        $m = $loader->load($model);

        if (empty($template)) {
            $template = empty($template) ? '<missing>' : $template;
            return;
        } else {
            $result = $generator->generate($m, $template, $outputFile);
            print $result . "\n";
        }
    }
}
