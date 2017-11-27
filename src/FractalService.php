<?php

namespace Nord\Lumen\Fractal;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Nord\Lumen\Fractal\Contracts\FractalService as FractalServiceContract;
use League\Fractal\Manager;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;

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
    public function item($data, TransformerAbstract $transformer = null, $resourceKey = null)
    {
        return $this->makeBuilder(Item::class, $data, $transformer, $resourceKey);
    }


    /**
     * @inheritdoc
     */
    public function collection($data, TransformerAbstract $transformer = null, $resourceKey = null)
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

        $this->includes = array_merge($this->includes, (array) $includes);
    }


    /**
     * @inheritdoc
     */
    public function setDefaultSerializer(SerializerAbstract $serializer)
    {
        $this->defaultSerializer = $serializer;
    }


    /**
     * Creates a builder for serializing data.
     *
     * @param string                    $resourceClass
     * @param mixed                    $data
     * @param TransformerAbstract|null $transformer
     * @param string|null              $resourceKey
     *
     * @return FractalBuilder
     */
    protected function makeBuilder(
        $resourceClass,
        $data,
        TransformerAbstract $transformer = null,
        $resourceKey = null
    ) {
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
    protected function makeFractal()
    {
        $fractal = new Manager();

        if (isset($this->defaultSerializer)) {
            $fractal->setSerializer($this->defaultSerializer);
        }

        if (isset($this->includes)) {
            $fractal->parseIncludes($this->includes);
        }

        return $fractal;
    }
}
