<?php

use Illuminate\Support\Str;
use VictorYoalli\LaravelCodeGenerator\Helper;

if (! function_exists('str')) {
    /**
     * Create a collection from the given value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Support\Collection
     */
    function str(string $expression)
    {
        return Str::of($expression);
    }
}
if (! function_exists('literal')) {
    function literal(string $str='{{')
    {
        return $str;
    }
}

if (! function_exists('openDoubleCurly')) {
    function openDoubleCurly()
    {
        return '{{';
    }
}

if (! function_exists('str_match')) {
    function str_match(string $expression, string $regex)
    {
        return Str::of($expression)->match($regex)->__toString();
    }
}

if (! function_exists('code')) {
    function code()
    {
        return new Helper();
    }
}
