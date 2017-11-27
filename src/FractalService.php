<?php

namespace Nord\Lumen\Fractal;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;
use Nord\Lumen\Fractal\Contracts\FractalService as FractalServiceContract;

class FractalService implements FractalServiceContract
{

    /**
     * @var array
     */
    private $includes = [];

    /**
     * @var SerializerAbstract
     */
    private $defaultSerializer;


    /**
     * @inheritdoc
     */
    public function item($data, $transformer = null, ?string $resourceKey = null)
    {
        return $this->makeBuilder(Item::class, $data, $transformer, $resourceKey);
    }


    /**
     * @inheritdoc
     */
    public function collection($data, $transformer = null, ?string $resourceKey = null)
    {
        return $this->makeBuilder(Collection::class, $data, $transformer, $resourceKey);
    }


    /**
     * @inheritdoc
     */
    public function parseIncludes($includes)
    {
        if (is_string($includes)) {
            $includes = explode(',', $includes);
        }

        $this->includes = array_merge($this->includes, $includes);
        
        return $this;
    }


    /**
     * @inheritdoc
     */
    public function setDefaultSerializer(SerializerAbstract $serializer)
    {
        $this->defaultSerializer = $serializer;
        
        return $this;
    }


    /**
     * Creates a builder for serializing data.
     *
     * @param string                            $resourceClass
     * @param mixed                             $data
     * @param TransformerAbstract|callable|null $transformer
     * @param string|null                       $resourceKey
     *
     * @return FractalBuilder
     */
    protected function makeBuilder(string $resourceClass, $data, $transformer = null, string $resourceKey = null): FractalBuilder
    {
        $fractal = $this->makeFractal();
        $builder = new FractalBuilder($fractal, $resourceClass, $data);

        if ($transformer !== null) {
            $builder->setTransformer($transformer);
        }

        if ($resourceKey !== null) {
            $builder->setResourceKey($resourceKey);
        }

        return $builder;
    }


    /**
     * @return Manager
     */
    protected function makeFractal(): Manager
    {
        $fractal = new Manager();

        if ($this->defaultSerializer) {
            $fractal->setSerializer($this->defaultSerializer);
        }

        $fractal->parseIncludes($this->includes);

        return $fractal;
    }
}
