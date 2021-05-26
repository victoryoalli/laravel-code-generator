<?php

namespace VictorYoalli\LaravelCodeGenerator;

use Illuminate\Support\Facades\Blade;

class BladeDirectives
{
    public static function boot()
    {
        Blade::directive('phpsol', function () {
            return "<?php echo '<?php '.PHP_EOL; ?>";
        });

        Blade::directive('tag', function ($expression) {
            $expression = self::removeQuotes($expression);
            $result = "<{$expression}>";
            return $result;
        });

        Blade::directive('literal', function ($str) {
            // $result = self::removeQuotes($str);
            return literal($str);
        });

        Blade::directive('title', function ($expression) {
            return "<?php echo Str::title($expression); ?>";
        });

        Blade::directive('snake', function ($expression) {
            return "<?php echo Str::snake($expression); ?>";
        });

        Blade::directive('human', function ($expression) {
            return "<?php echo Str::human($expression); ?>";
        });

        Blade::directive('pascal', function ($expression) {
            return "<?php echo Str::pascal($expression); ?>";
        });

        Blade::directive('slug', function ($expression) {
            return "<?php echo Str::slug($expression); ?>";
        });

        Blade::directive('camel', function ($expression) {
            return "<?php echo Str::camel($expression); ?>";
        });

        Blade::directive('plural', function ($expression) {
            return "<?php echo Str::plural($expression); ?>";
        });

        Blade::directive('singular', function ($expression) {
            return "<?php echo Str::singular($expression); ?>";
        });

        Blade::directive('contains', function ($regex, $expression) {
            return preg_match($regex, $expression) > 0;
        });

        Blade::directive('replace', function ($pattern, $replacement, $subject) {
            return preg_replace($pattern, $replacement, $subject);
        });
    }
    private static function removeQuotes(string $str)
    {
        return preg_replace("/^(\"|')(.+)(\"|')$/", '${2}', $str);
    }
}
