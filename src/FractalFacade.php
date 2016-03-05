<?php

namespace Nord\Lumen\Fractal;

use Illuminate\Support\Facades\Facade;

class FractalFacade extends Facade
{

    /**
     * @inheritdoc
     */
    protected static function getFacadeAccessor()
    {
        return FractalService::class;
    }
}
