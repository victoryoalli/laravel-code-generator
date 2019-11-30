<?php

namespace VictorYoalli\LaravelCodeGenerator;

use Illuminate\Support\ServiceProvider;
use VictorYoalli\LaravelCodeGenerator\Console\GenerateCommand;

class LaravelCodeGeneratorServiceProvider extends ServiceProvider
{
    // protected $defer = true;

    public function boot()
    {
        $viewPath = __DIR__ . '/../resources/views';

        $this->loadViewsFrom($viewPath, 'laravel-code-generator');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $viewPath => resource_path('views/vendor/laravel-code-generator'),
            ], 'views');

            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('laravel-code-generator.php'),
            ], 'config');
            $this->app->view->addExtension('blade.js', 'blade');
            $this->app->view->addExtension('blade.vue', 'blade');
            $this->app->view->addExtension('blade.jsx', 'blade');

            $this->commands([
                GenerateCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laravel-code-generator');
        $this->app->singleton('laravel-code-generator', function () {
            return new CodeGenerator;
        });
    }
}
