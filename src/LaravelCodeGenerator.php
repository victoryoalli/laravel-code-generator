<?php

namespace VictorYoalli\LaravelCodeGenerator;

use Illuminate\Support\Facades\Facade;

class LaravelCodeGenerator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'LaravelCodeGenerator';
    }
}
