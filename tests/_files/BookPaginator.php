<?php

namespace Nord\Lumen\Tests\Files;

use League\Fractal\Pagination\PaginatorInterface;

class BookPaginator implements PaginatorInterface
{
    /**
     * @var array
     */
    private $books = [];

    /**
     * @param array $books
     */
    public function __construct(array $books)
    {
        $this->books = $books;
    }

    /**
     * @inheritdoc
     */
    public function getCurrentPage()
    {
        return 1;
    }

    /**
     * @inheritdoc
     */
    public function getLastPage()
    {
        return 1;
    }

    /**
     * @inheritdoc
     */
    public function getTotal()
    {
        return count($this->books);
    }

    /**
     * @inheritdoc
     */
    public function getCount()
    {
        return count($this->books);
    }

    /**
     * @inheritdoc
     */
    public function getPerPage()
    {
        return count($this->books);
    }

    /**
     * @inheritdoc
     */
    public function getUrl($page)
    {
        return '';
    }
}
