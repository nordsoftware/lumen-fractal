<?php

namespace Nord\Lumen\Fractal\Tests;

use Nord\Lumen\Fractal\FractalService;
use Nord\Lumen\Fractal\FractalServiceProvider;

class FractalServiceProviderTest extends \Codeception\Test\Unit
{

    use \Codeception\Specify;

    /**
     * @var MockApplication
     */
    protected $app;

    /**
     * @inheritdoc
     */
    protected function setup()
    {
        $this->app = new MockApplication();
        $this->app->register(FractalServiceProvider::class);
    }

    /**
     *
     */
    public function testAssertCanBeRegistered()
    {
        $this->specify('verify serviceProvider is registered', function () {
            $service = $this->app->make(FractalService::class);
            verify($service)->isInstanceOf(FractalService::class);
        });
    }
}
