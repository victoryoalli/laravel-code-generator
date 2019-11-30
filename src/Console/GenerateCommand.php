<?php

namespace VictorYoalli\LaravelCodeGenerator\Console;

use Illuminate\Console\Command;
use VictorYoalli\LaravelCodeGenerator\CodeGenerator;
use VictorYoalli\LaravelCodeGenerator\Helper;
use VictorYoalli\LaravelCodeGenerator\ModelLoader;
use VictorYoalli\LaravelCodeGenerator\Template;

class GenerateCommand extends Command
{
    protected $signature = 'code:generate {model} {--s|set= : Select your set of templates} {--t|template=} ';

    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(ModelLoader $loader, CodeGenerator $generator)
    {
        $model = $this->argument('model');

        $template = $this->option('template');
        $templateSet = $this->option('set');

        if (empty($model)) {
            return;
        }
        $m = $loader->load($model);

        if (empty($template) && empty($templateSet)) {
            $template = empty($template) ? '<missing>' : $template;
            print "Template: {$template}\n";
            return;
        } elseif (empty($templateSet)) {
            // $m = $loader->load($model);
            $result = $generator->create($m, $template);
            print $result . "\n";
        } elseif (!empty($templateSet)) {
            $config = config("laravel-code-generator.{$templateSet}");
            // print_r( $config);
            foreach ($config as $key => $value) {
                $sourceDirectory = resource_path('views/vendor/laravel-code-generator') . DIRECTORY_SEPARATOR . "{$key}";
                $outputDirectory = config("laravel-code-generator.{$templateSet}.{$key}");
                print $sourceDirectory . "\n";
                print $outputDirectory . "\n";
                $tree = Template::structure($sourceDirectory, null, $outputDirectory);
                dump($tree);
                foreach ($tree as $filename => $out) {
                    if (!is_array($tree[$filename])) {
                        print "QQQ {$filename}\n";
                        print "{$filename} => " . self::newFilename($m->name, $out) . "\n";
                        $result = $generator->create($m, self::getTemplateName($key . '.' . $filename));
                        print $result . "\n";
                    }
                }
                return;
            }
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
