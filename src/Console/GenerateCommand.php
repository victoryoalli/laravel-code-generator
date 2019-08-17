<?php

namespace VictorYoalli\LaravelCodeGenerator\Console;

use Illuminate\Console\Command;
use VictorYoalli\LaravelCodeGenerator\ModelLoader;

class GenerateCommand extends Command
{
    protected $name = 'lcg:generate';

    protected $description = '';

    public function handle()
    {
        print 'Laravel CodeGenerator' . "\n";
        $loader = new ModelLoader($this->laravel);
        $m = $loader->load('App\User');
        dd($m);
    }
}
