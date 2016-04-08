<?php

namespace Nord\Lumen\Tests\Files;

/**
 * Class Book.
 *
 * @package Nord\Lumen\Tests\Files
 */
class Book
{

    /**
     * @var string $author
     */
    private $author;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var string $publisher
     */
    private $publisher;

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param string $publisher
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

}
