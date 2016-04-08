<?php

use Nord\Lumen\Fractal\FractalService;
use Nord\Lumen\Tests\Files\Book;
use Nord\Lumen\Tests\Files\BookTransformer;
use Nord\Lumen\Tests\Files\Author;

/**
 * Class FractalTest.
 */
class FractalTest extends \Codeception\TestCase\Test
{

    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

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
    protected function _after()
    {
        $this->service     = null;
        $this->book        = null;
        $this->author      = null;
        $this->transformer = null;
    }

    /**
     * Tests the fractal item.
     */
    public function testItem()
    {
        $this->service     = new FractalService();
        $this->author      = new Author('Test', 'Author');
        $this->book        = new Book('Test Book', 'Test Publisher', $this->author);
        $this->transformer = new BookTransformer();

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
        $this->service     = new FractalService();
        $this->author      = new Author('Test', 'Author');
        $this->book        = new Book('Test Book', 'Test Publisher', $this->author);
        $this->transformer = new BookTransformer();

        $books = [];
        for ($i = 0; $i < 5; $i++) {
            $author  = new Author('Test ' . $i, 'Author' . $i);
            $book    = new Book('Test Book ' . $i, 'Test Publisher ' . $i, $author);
            $books[] = $book;
        }

        $this->specify('Array does not contain specified amount of items', function () use ($books) {
            $collection = $this->service->collection($books, $this->transformer)->toArray();
            verify(count($collection['data']))->equals(5);
        });
    }

    /**
     * Tests the Author include.
     */
    public function testAuthorInclude()
    {
        $this->service     = new FractalService();
        $this->author      = new Author('Test', 'Author');
        $this->book        = new Book('Test Book', 'Test Publisher', $this->author);
        $this->transformer = new BookTransformer();

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
}
