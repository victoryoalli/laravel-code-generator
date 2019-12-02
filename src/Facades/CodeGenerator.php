<?php

namespace VictorYoalli\LaravelCodeGenerator\Facades;

use Illuminate\Support\Facades\Facade;

class CodeGenerator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'code-generator';
    }
}
