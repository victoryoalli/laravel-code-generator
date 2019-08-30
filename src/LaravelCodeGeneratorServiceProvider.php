<?php

namespace VictorYoalli\LaravelCodeGenerator;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use VictorYoalli\LaravelCodeGenerator\Console\GenerateCommand;

class LaravelCodeGeneratorServiceProvider extends ServiceProvider
{
    // protected $defer = true;

    public function boot()
    {
        $viewPath = __DIR__ . '/../resources/views';
        $this->loadViewsFrom($viewPath, 'laravel-code-generator');
        $this->publishes([
            $viewPath => resource_path('views/vendor/laravel-code-generator'),
        ], 'views');
        $this->publishes([
            __DIR__ . '/../config/laravel-code-generator.php' => base_path('config/laravel-code-generator.php'),
        ], 'config');
        $this->app->view->addExtension('blade.js', 'blade');
        $this->app->view->addExtension('blade.vue', 'blade');
        $this->app->view->addExtension('blade.jsx', 'blade');
        $this->app->view->composer('*', function ($view) {
            $view_name = str_replace('.', '-', $view->getName());
            // print_r(pathinfo($view->getPath()));
            $this->app->view->share('VIEW_NAME', $view_name);
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-code-generator.php', 'laravel-code-generator');
        $this->app->singleton('LaravelCodeGenerator', function ($app) {
            return new CodeGenerator($app);
        });
        $this->app->singleton(CodeGenerator::class, function ($app) {
            $files = $app->make(Filesystem::class);
            return new CodeGenerator($app, $app['files']);
        });
        $this->app->singleton(ModelLoader::class, function ($app) {
            return new ModelLoader($app);
        });
    }
}
