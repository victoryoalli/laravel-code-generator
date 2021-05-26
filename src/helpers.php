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

if (! function_exists('code')) {
    function code()
    {
        return new Helper();
    }
}
