<?php

use Illuminate\Support\Collection;
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
     * @inheritdoc
     */
    protected function _before()
    {
        $this->service = new FractalService();
    }

    /**
     * @inheritdoc
     */
    protected function _after()
    {
        $this->service = null;
    }

    /**
     * Tests the fractal item.
     */
    public function testItem()
    {
        $author = new Author('Test', 'Author');
        $book   = new Book('Test Book', 'Test Publisher', $author);

        $item = $this->service->item($book, new BookTransformer())->toArray();

        $this->specify('The key "data" is required.', function () use ($item) {
            verify($item)->hasKey('data');
        });

        $bookData = $item['data'];

        $this->specify('The book title must equal "Test Book".', function () use ($bookData) {
            verify($bookData['title'])->equals('Test Book');
        });
    }

    /**
     * Tests the fractal collection.
     */
    public function testCollection()
    {

        $books = array();

        for ($i = 0; $i < 5; $i++) {
            $author  = new Author('Test ' . $i, 'Author' . $i);
            $book    = new Book('Test Book ' . $i, 'Test Publisher ' . $i, $author);
            $books[] = $book;
        }

        $collection = $this->service->collection($books, new BookTransformer())->toArray();

        $this->specify('Array does not contain specified amount of items', function () use ($collection) {
            verify(count($collection['data']))->equals(5);
        });
    }

    /**
     * Tests the Author include.
     */
    public function testAuthorInclude()
    {
        $author = new Author('Test', 'Author');
        $book   = new Book('Test Book', 'Test Publisher', $author);

        $item = $this->service->item($book, new BookTransformer())->toArray();

        $this->specify('The key "data" is required.', function () use ($item) {
            verify($item)->hasKey('data');
        });

        $bookData = $item['data'];

        $this->specify('Author last name must be "Author".', function () use ($bookData) {
            verify($bookData['author'])->hasKey('data');
            verify($bookData['author']['data'])->hasKey('lastName');
            verify($bookData['author']['data']['lastName'])->equals('Author');
        });
    }
}
