<?php

namespace Nord\Lumen\Fractal\Contracts;

use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;

interface FractalBuilder
{
    
    /**
     * Sets the meta data to add to the serialized data.
     *
     * @param array $meta
     *
     * @return FractalBuilder
     *
     * @see http://fractal.thephpleague.com/serializers#jsonapiserializer
     */
    public function setMeta(array $meta);

    /**
     * Sets the transformer to use for serializing data.
     *
     * @param TransformerAbstract $transformer
     *
     * @return FractalBuilder
     *
     * @see http://fractal.thephpleague.com/transformers/
     */
    public function setTransformer(TransformerAbstract $transformer);


    /**
     * Sets the resource key to use for serializing data.
     *
     * @param string $resourceKey
     *
     * @return FractalBuilder
     *
     * @see http://fractal.thephpleague.com/transformers/
     */
    public function setResourceKey(string $resourceKey);


    /**
     * Sets the paginator to use for serializing data.
     * Only applicable for collections.
     *
     * @param PaginatorInterface $paginator
     * 
     * @throws \InvalidArgumentException
     *
     * @return FractalBuilder
     *
     * @see http://fractal.thephpleague.com/pagination#using-paginators
     */
    public function setPaginator(PaginatorInterface $paginator);


    /**
     * Sets the cursor to use for serializing data.
     * Only applicable for collections.
     *
     * @param CursorInterface $cursor
     * 
     * @throws \InvalidArgumentException
     *
     * @return mixed
     *
     * @see http://fractal.thephpleague.com/pagination#using-cursors
     */
    public function setCursor(CursorInterface $cursor);


    /**
     * Sets the serializer to use for serializing data.
     *
     * @param SerializerAbstract $serializer
     *
     * @return FractalBuilder
     *
     * @see http://fractal.thephpleague.com/serializers/
     */
    public function setSerializer(SerializerAbstract $serializer);


    /**
     * Returns the data as an array, serializing it first if necessary.
     *
     * @return array
     */
    public function toArray();


    /**
     * Returns the data as a JSON string, serializing it first if necessary.
     *
     * @return string
     */
    public function toJson();
}
