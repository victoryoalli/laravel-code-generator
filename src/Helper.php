<?php

namespace VictorYoalli\LaravelCodeGenerator;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;

class Helper // extends Facade
{
    const PHP_SOL = '<?php';
    const DOUBLE_CURLY_OPEN = '{{';
    const DOUBLE_CURLY_CLOSE = '}}';
    const CC_OPEN = self::DOUBLE_CURLY_OPEN;
    const CC_CLOSE = self::DOUBLE_CURLY_CLOSE;

    public static function e($text)
    {
        return $text;
    }

    public static function contains($regex, $text)
    {
        return preg_match($regex, $text) > 0;
    }

    public static function replace($pattern, $replacement, $subject)
    {
        return preg_replace($pattern, $replacement, $subject);
    }

    public static function human($text)
    {
        $text = self::camel($text);
        return preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', $text);
    }

    public static function slug($text)
    {
        return Str::slug(self::human($text));
    }

    public static function title($text)
    {
        return Str::title(self::human($text));
    }

    public static function camel($text)
    {
        return Str::camel($text);
    }

    public static function pascal($text)
    {
        return ucfirst(Str::camel($text));
    }

    public static function plural($text)
    {
        return Str::plural($text);
    }

    public static function is_camel($text)
    {
        return preg_match('/^[a-z]+((\d)|([A-Z0-9][a-z0-9]+))*([A-Z])?$/', $text) > 0;
    }

    public static function is_pascal($text)
    {
        return preg_match('/^([A-Z][a-z0-9]+)((\d)|([A-Z0-9][a-z0-9]+))*([A-Z])?$/', $text) > 0;
    }

    public static function is_slug($text)
    {
        return \preg_match('/^[a-z][-a-z0-9]*$/', $text) > 0;
    }
}
