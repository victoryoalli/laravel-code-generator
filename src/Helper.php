<?php

namespace VictorYoalli\LaravelCodeGenerator;

use Illuminate\Support\Str;

class Helper
{
    const PHP_SOL = '<?php';
    const AMPER_DOUBLE_CURLY_OPEN = '@{{';
    const DOUBLE_CURLY_OPEN = '{{';
    const DOUBLE_CURLY_CLOSE = '}}';
    const ACC_OPEN = self::AMPER_DOUBLE_CURLY_OPEN;
    const CC_OPEN = self::DOUBLE_CURLY_OPEN;
    const CC_CLOSE = self::DOUBLE_CURLY_CLOSE;

    public function PHPSOL()
    {
        return self::PHP_SOL;
    }

    public function doubleCurlyOpen()
    {
        return self::CC_OPEN;
    }

    public function doubleCurlyClose()
    {
        return self::CC_CLOSE;
    }

    public function arroba()
    {
        return '@';
    }

    public function e($text)
    {
        return $text;
    }

    public function contains($regex, $text)
    {
        return preg_match($regex, $text) > 0;
    }

    public function replace($pattern, $replacement, $subject)
    {
        return preg_replace($pattern, $replacement, $subject);
    }

    public function human($text)
    {
        $text = self::camel($text);
        return preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', $text);
    }

    public function slug($text)
    {
        return Str::slug(self::human($text));
    }

    public function title($text)
    {
        return Str::title(self::human($text));
    }

    public function camel($text)
    {
        return Str::camel($text);
    }

    public function pascal($text)
    {
        return ucfirst(Str::camel($text));
    }

    public function snake($text)
    {
        return Str::snake($text);
    }

    public function plural($text)
    {
        return Str::plural($text);
    }

    public function singular($text)
    {
        return Str::singular($text);
    }

    public function is_camel($text)
    {
        return preg_match('/^[a-z]+((\d)|([A-Z0-9][a-z0-9]+))*([A-Z])?$/', $text) > 0;
    }

    public function is_pascal($text)
    {
        return preg_match('/^([A-Z][a-z0-9]+)((\d)|([A-Z0-9][a-z0-9]+))*([A-Z])?$/', $text) > 0;
    }

    public function is_slug($text)
    {
        return \preg_match('/^[a-z][-a-z0-9]*$/', $text) > 0;
    }
}
