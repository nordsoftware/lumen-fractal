<?php

namespace Nord\Lumen\Fractal;

use League\Fractal\Manager;
use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\Scope;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;
use Nord\Lumen\Fractal\Contracts\FractalBuilder as FractalBuilderContract;
use Nord\Lumen\Fractal\Exceptions\InvalidArgument;
use Nord\Lumen\Fractal\Exceptions\NotApplicable;

class FractalBuilder implements FractalBuilderContract
{
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * @var string
     */
    private $resourceClass;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @var array
     */
    private $meta = [];

    /**
     * @var string
     */
    private $resourceKey;

    /**
     * @var TransformerAbstract
     */
    private $transformer;

    /**
     * @var SerializerAbstract
     */
    private $serializer;

    /**
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * @var CursorInterface
     */
    private $cursor;

    /**
     * @var array
     */
    private static $validResourceClasses = [
        self::RESOURCE_COLLECTION,
        self::RESOURCE_ITEM,
    ];

    /**
     * FractalBuilder constructor.
     *
     * @param Manager $fractal
     * @param string  $resourceClass
     * @param mixed   $data
     */
    public function __construct(Manager $fractal, $resourceClass, $data)
    {
        $this->setFractal($fractal);
        $this->setResourceClass($resourceClass);
        $this->setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function setMeta(array $meta)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTransformer(TransformerAbstract $transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setResourceKey($resourceKey)
    {
        if (!is_string($resourceKey) || strlen($resourceKey) === 0) {
            throw new InvalidArgument('Resource key must be a non-empty string.');
        }

        $this->resourceKey = $resourceKey;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPaginator(PaginatorInterface $paginator)
    {
        if ($this->resourceClass !== self::RESOURCE_COLLECTION) {
            throw new NotApplicable('Paginators can only be used with collections.');
        }

        $this->paginator = $paginator;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCursor(CursorInterface $cursor)
    {
        if ($this->resourceClass !== self::RESOURCE_COLLECTION) {
            throw new NotApplicable('Cursors can only be used with collections.');
        }

        $this->cursor = $cursor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSerializer(SerializerAbstract $serializer)
    {
        $this->serializer = $serializer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->makeScope()->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function toJson()
    {
        return $this->makeScope()->toJson();
    }

    /**
     * Creates the resource for this builder.
     *
     * @return ResourceAbstract
     */
    protected function makeResource()
    {
        /** @var Item|Collection $resource */
        $resource = new $this->resourceClass($this->data, $this->transformer, $this->resourceKey);

        if (!empty($this->meta)) {
            $resource->setMeta($this->meta);
        }

        if ($resource instanceof Collection && isset($this->paginator)) {
            $resource->setPaginator($this->paginator);
        }

        return $resource;
    }

    /**
     * Creates the scope for this builder.
     *
     * @return Scope
     */
    protected function makeScope()
    {
        $resource = $this->makeResource();

        if (isset($this->serializer)) {
            $this->fractal->setSerializer($this->serializer);
        }

        return $this->fractal->createData($resource);
    }

    /**
     * @param Manager $fractal
     */
    private function setFractal(Manager $fractal)
    {
        if ($fractal === null) {
            throw new InvalidArgument('Fractal must be an instance of League\Fractal\Manager.');
        }

        $this->fractal = $fractal;
    }

    /**
     * @param string $resourceClass
     */
    private function setResourceClass($resourceClass)
    {
        if (!is_string($resourceClass) || strlen($resourceClass) === 0) {
            throw new InvalidArgument('Resource class must be a non-empty string.');
        }

        if (!in_array($resourceClass, self::$validResourceClasses)) {
            throw new InvalidArgument('Resource class is invalid.');
        }

        $this->resourceClass = $resourceClass;
    }

    /**
     * @param mixed $data
     */
    private function setData($data)
    {
        $this->data = $data;
    }
}
