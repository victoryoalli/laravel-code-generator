<?php

namespace VictorYoalli\LaravelCodeGenerator\Console;

use Illuminate\Console\Command;
use VictorYoalli\LaravelCodeGenerator\CodeGenerator;
use VictorYoalli\LaravelCodeGenerator\ModelLoader;

class GenerateCommand extends Command
{
    protected $signature = 'code:generate {model} {--t|template= : template location} {--o|outfile= : Output file location} {--f|force : force overwrite}';

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
        $force = $this->option('force');

        if (empty($model)) {
            return;
        }
        $m = $loader->load($model);

        if (empty($template)) {
            $template = empty($template) ? '<missing>' : $template;
            return;
        } else {
            $result = $generator->generate($m, $template, $outputFile, $force);
            print $result . "\n";
        }
    }
}
