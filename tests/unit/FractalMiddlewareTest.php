<?php

namespace Nord\Lumen\Fractal\Tests;

use Illuminate\Http\Request;
use Nord\Lumen\Fractal\FractalService;
use Nord\Lumen\Fractal\FractalMiddleware;

class FractalMiddlewareTest extends \Codeception\Test\Unit
{
    use \Codeception\Specify;

    /**
     * @var FractalService
     */
    private $service;

    /**
     * @var FractalMiddleware
     */
    private $middleware;

    /**
     * @inheritdoc
     */
    protected function setup()
    {
        $this->service    = new FractalService();
        $this->middleware = new FractalMiddleware($this->service);
    }

    /**
     *
     */
    public function testAssertParseInclude()
    {
        $this->specify('verify middleware parse include', function () {
            $req = new Request();
            $req->offsetSet('include', 'foo,bar,baz');

            verify($this->middleware->handle($req, function () {
                return true;
            }))->equals(true);
        });
    }
}
