<?php

use VictorYoalli\LaravelCodeGenerator\Helper;

if (! function_exists('code')) {
    function code()
    {
        return new Helper();
    }
}
