<?php

namespace Nord\Lumen\Fractal\Tests;

use League\Fractal\Pagination\Cursor;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Serializer\DataArraySerializer;
use Nord\Lumen\Fractal\FractalService;
use Nord\Lumen\Tests\Files\Book;
use Nord\Lumen\Tests\Files\BookPaginator;
use Nord\Lumen\Tests\Files\BookTransformer;
use Nord\Lumen\Tests\Files\Author;

class FractalServiceTest extends \Codeception\Test\Unit
{
    use \Codeception\Specify;

    /**
     * @var \Nord\Lumen\Fractal\FractalService
     */
    protected $service;

    /**
     * @var Author
     */
    private $author;

    /**
     * @var Book
     */
    private $book;

    /**
     * @var BookTransformer
     */
    private $transformer;

    /**
     * @inheritdoc
     */
    protected function setup()
    {
        $this->service = new FractalService();
        $this->service->setDefaultSerializer(new DataArraySerializer());

        $this->author = new Author('Test', 'Author');
        $this->book = new Book('Test Book', 'Test Publisher', $this->author);
        $this->transformer = new BookTransformer();
    }

    /**
     * Tests the fractal item.
     */
    public function testItem()
    {
        $this->specify('The key "data" is required.', function () {
            $item = $this->service->item($this->book, $this->transformer)->toArray();
            verify($item)->hasKey('data');
        });

        $this->specify('The book title must equal "Test Book".', function () {
            $item = $this->service->item($this->book, $this->transformer)->toArray();
            verify($item['data']['title'])->equals('Test Book');
        });
    }

    /**
     * Tests the fractal collection.
     */
    public function testCollection()
    {
        $this->specify('Array does not contain specified amount of items', function () {
            $collection = $this->service->collection([$this->book], $this->transformer)->toArray();
            verify(count($collection['data']))->equals(1);
            verify(count($collection['data']))->equals(1);
        });
    }

    /**
     * Tests the Author include.
     */
    public function testAuthorInclude()
    {
        $this->specify('The key "data" is required.', function () {
            $item = $this->service->item($this->book, $this->transformer)->toArray();
            verify($item)->hasKey('data');
        });

        $this->specify('Author last name must be "Author".', function () {
            $item = $this->service->item($this->book, $this->transformer)->toArray();
            verify($item['data']['author'])->hasKey('data');
            verify($item['data']['author']['data'])->hasKey('lastName');
            verify($item['data']['author']['data']['lastName'])->equals('Author');
        });
    }

    /**
     * Tests the item&collection meta support.
     */
    public function testAssertHasMeta()
    {
        $meta = [
            'foo' => 'bar'
        ];

        $this->specify('The key "meta" is required for item.', function () use ($meta) {
            $item = $this->service->item($this->book, $this->transformer)
                ->setMeta($meta)
                ->toArray();
            verify($item)->hasKey('meta');
            verify($item['meta'])->equals($meta);
        });

        $this->specify('The key "meta" is required for collection.', function () use ($meta) {
            $collection = $this->service->collection([$this->book], $this->transformer)
                ->setMeta($meta)
                ->toArray();
            verify($collection)->hasKey('meta');
            verify($collection['meta'])->equals($meta);
        });
    }

    /**
     *
     */
    public function testAssertJson()
    {
        $this->specify('The item has to be in JSON format.', function () {
            $item = $this->service->item($this->book, $this->transformer)->toJson();
            verify($item)->equals('{"data":{"title":"Test Book","publisher":"Test Publisher","author":{"data":{"firstName":"Test","lastName":"Author"}}}}');
        });

        $this->specify('The collection has to be in JSON format.', function () {
            $collection = $this->service->collection([$this->book], $this->transformer)->toJson();
            verify($collection)->equals('{"data":[{"title":"Test Book","publisher":"Test Publisher","author":{"data":{"firstName":"Test","lastName":"Author"}}}]}');
        });
    }

    /**
     *
     */
    public function testAssertSerializer()
    {
        $this->specify('The serializer is array serializer', function () {
            $builder = $this->service->item($this->book, $this->transformer);
            $builder->setSerializer(new ArraySerializer());
            $item = $builder->toArray();
            verify($item)->equals([
                'title' => 'Test Book',
                'publisher' => 'Test Publisher',
                'author' => [
                    'firstName' => 'Test',
                    'lastName'  => 'Author',
                ]
            ]);
        });

        $this->specify('The serializer is data array serializer', function () {
            $builder = $this->service->item($this->book, $this->transformer);
            $builder->setSerializer(new DataArraySerializer());
            $item = $builder->toArray();
            verify($item)->equals([
                'data' =>  [
                    'title' => 'Test Book',
                    'publisher' => 'Test Publisher',
                    'author' => [
                        'data' => [
                            'firstName' => 'Test',
                            'lastName'  => 'Author',
                        ]
                    ]
                ]
            ]);
        });
    }

    /**
     *
     */
    public function testAssertResourceKey()
    {
        $this->specify('The fractal builder resource key can be set.', function () {
            $item = $this->service->item($this->book, $this->transformer);
            $item->setResourceKey('book');
            $array = $item->toArray();
            verify($array)->hasKey('data');
        });

        $this->specify('The fractal service can set the builder resource key.', function () {
            $item = $this->service->item($this->book, $this->transformer, 'book')->toArray();
            verify($item)->hasKey('data');
        });
    }

    /**
     *
     */
    public function testAssertPaginator()
    {
        $this->specify('The collection can have a paginator', function () {
            $books = [$this->book];
            $collection = $this->service->collection($books, $this->transformer)
                ->setPaginator(new BookPaginator($books))
                ->toArray();
            verify($collection)->hasKey('meta');
            verify($collection['meta'])->hasKey('pagination');
        });

        $this->specify('The item cannot have a paginator', function () {
            $this->service->item($this->book, $this->transformer)
                ->setPaginator(new BookPaginator([]))
                ->toArray();
        }, ['throws' => 'Nord\Lumen\Fractal\Exceptions\NotApplicable']);
    }

    /**
     *
     */
    public function testAssertCursor()
    {
        $this->specify('The collection can have a cursor', function () {
            $collection = $this->service->collection([$this->book], $this->transformer)
                ->setCursor(new Cursor())
                ->toArray();
            verify(count($collection['data']))->equals(1);
        });

        $this->specify('The item cannot have a cursor', function () {
            $this->service->item($this->book, $this->transformer)
                ->setCursor(new Cursor())
                ->toArray();
        }, ['throws' => 'Nord\Lumen\Fractal\Exceptions\NotApplicable']);
    }
}
