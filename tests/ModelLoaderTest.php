<?php

namespace VictorYoalli\LaravelCodeGenerator\Tests;

use Orchestra\Testbench\TestCase;
use VictorYoalli\LaravelCodeGenerator\ModelLoader;

class ModelLoaderTest extends TestCase
{
    /** @test */
    public function it_reads_a_model()
    {
        $loader = new ModelLoader($this->app);
        $this->assertNotNull($model);
    }
}
