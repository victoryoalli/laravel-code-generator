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
        $this->publishes([
            $viewPath => resource_path('views/vendor/laravel-code-generator'),
        ], 'views');
        $this->app->view->addExtension('blade.js', 'blade');
        $this->app->view->addExtension('blade.vue', 'blade');
        $this->app->view->composer('*', function ($view) {
            $view_name = str_replace('.', '-', $view->getName());
            // print_r(pathinfo($view->getPath()));
            $this->app->view->share('VIEW_NAME', $view_name);
            $php_start = '<?php' . "\n\n";
            $this->app->view->share('PHP_START', $php_start);
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->app->singleton('LaravelCodeGenerator', function ($app) {
            return new CodeGenerator($app);
        });
        $this->app->singleton(CodeGenerator::class, function ($app) {
            return new CodeGenerator($app);
        });
        $this->app->singleton(ModelLoader::class, function ($app) {
            return new ModelLoader($app);
        });
    }
}
