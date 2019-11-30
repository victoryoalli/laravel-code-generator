<?php

namespace VictorYoalli\LaravelCodeGenerator;

use Illuminate\Support\Facades\Facade;

class LaravelCodeGeneratorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'code-generator';
    }
}
