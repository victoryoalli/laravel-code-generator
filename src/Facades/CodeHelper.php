<?php

namespace VictorYoalli\LaravelCodeGenerator\Facades;

use Illuminate\Support\Facades\Facade;

class CodeHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'code-helper';
    }
}
