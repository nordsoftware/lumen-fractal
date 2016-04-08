<?php

use Illuminate\Support\Collection;
use Nord\Lumen\Fractal\FractalService;
use Nord\Lumen\Tests\Files\Book;
use Nord\Lumen\Tests\Files\BookTransformer;

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
     * Tests the fractal item.
     */
    public function testItem()
    {
        $this->service = new FractalService();

        $book = new Book();
        $book->setTitle('Test Book');
        $book->setAuthor('Test Author');
        $book->setPublisher('Test Publisher');

        $data = $this->service->item($book, new BookTransformer())->toArray();

        $this->specify('key "data" is required', function () use ($data) {
            verify($data)->hasKey('data');
        });

        $bookData = $data['data'];

        $this->specify('book title equals "Test Book"', function () use ($bookData) {
            verify($bookData['title'])->equals('Test Book');
        });
    }

    /**
     * Tests the fractal collection.
     */
    public function testCollection()
    {

    }
}
