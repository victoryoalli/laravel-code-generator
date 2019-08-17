<?php

namespace VictorYoalli\LaravelCodeGenerator;

use Illuminate\Support\ServiceProvider;
use VictorYoalli\LaravelCodeGenerator\Console\GenerateCommand;

class LaravelCodeGeneratorServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->app->bind('LaravelCodeGenerator', function ($app) {
            return new LaravelCodeGenerator($app);
        });
    }
}
