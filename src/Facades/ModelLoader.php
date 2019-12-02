<?php

namespace VictorYoalli\LaravelCodeGenerator\Facades;

use Illuminate\Support\Facades\Facade;

class ModelLoader extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'model-loader';
    }
}
