<?php

namespace Nord\Lumen\Fractal\Tests;

use Laravel\Lumen\Application;

class MockApplication extends Application
{
    /**
     * @inheritdoc
     */
    public function __construct($basePath = null)
    {
        parent::__construct(realpath(__DIR__ . '/../'));
    }
}
