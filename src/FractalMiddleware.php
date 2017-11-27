<?php

namespace Nord\Lumen\Fractal;

use Closure;
use Illuminate\Http\Request;

class FractalMiddleware
{

    /**
     * @var FractalService
     */
    private $service;

    /**
     * FractalMiddleware constructor.
     *
     * @param FractalService $service
     */
    public function __construct(FractalService $service)
    {
        $this->service = $service;
    }

    /**
     * Run the request filter.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('include')) {
            $this->service->parseIncludes($request->get('include'));
        }

        return $next($request);
    }
}
