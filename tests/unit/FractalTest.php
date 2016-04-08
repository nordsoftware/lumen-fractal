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
