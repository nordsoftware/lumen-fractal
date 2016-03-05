<?php

namespace Nord\Lumen\Fractal\Contracts;

use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;
use Nord\Lumen\Fractal\FractalBuilder;

interface FractalService
{

    /**
     * Serializes a single item.
     *
     * @param mixed                             $data
     * @param TransformerAbstract|callable|null $transformer
     * @param string|null                       $resourceKey
     *
     * @return FractalBuilder
     */
    public function item($data, TransformerAbstract $transformer = null, $resourceKey = null);


    /**
     * Serializes a collection of items.
     *
     * @param mixed                             $data
     * @param TransformerAbstract|callable|null $transformer
     * @param string|null                       $resourceKey
     *
     * @return FractalBuilder
     */
    public function collection($data, TransformerAbstract $transformer = null, $resourceKey = null);


    /**
     * Parses includes from either a string (GET query parameter) or an array
     * and stores them so that they are available at the time of serialization.
     *
     * @param string|array $includes
     *
     * @see http://fractal.thephpleague.com/transformers#including-data
     */
    public function parseIncludes($includes);


    /**
     * Sets the default serializer to use for serializing data.
     *
     * @param SerializerAbstract $serializer
     *
     * @see http://fractal.thephpleague.com/serializers/
     */
    public function setDefaultSerializer(SerializerAbstract $serializer);
}
