<?php

namespace Nord\Lumen\Fractal\Contracts;

use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;

interface FractalService
{

    /**
     * Serializes a single item.
     *
     * @param mixed                             $data
     * @param TransformerAbstract|callable|null $transformer
     * @param string|null                       $resourceKey
     *
     * @return $this
     */
    public function item($data, $transformer = null, ?string $resourceKey = null);


    /**
     * Serializes a collection of items.
     *
     * @param mixed                             $data
     * @param TransformerAbstract|callable|null $transformer
     * @param string|null                       $resourceKey
     *
     * @return $this
     */
    public function collection($data, $transformer = null, ?string $resourceKey = null);


    /**
     * Parses includes from either a string (GET query parameter) or an array
     * and stores them so that they are available at the time of serialization.
     *
     * @param string|array $includes
     * 
     * @return $this
     *
     * @see http://fractal.thephpleague.com/transformers#including-data
     */
    public function parseIncludes($includes);


    /**
     * Sets the default serializer to use for serializing data.
     *
     * @param SerializerAbstract $serializer
     * 
     * @return $this
     *
     * @see http://fractal.thephpleague.com/serializers/
     */
    public function setDefaultSerializer(SerializerAbstract $serializer);
}
