<?php

namespace Nord\Lumen\Tests\Files;

use League\Fractal\TransformerAbstract;

/**
 * Class BookTransformer.
 */
class BookTransformer extends TransformerAbstract
{
    /**
     * {@inheritdoc}
     */
    protected $defaultIncludes = [
        'author',
    ];

    /**
     * @param Book $book
     *
     * @return array
     */
    public function transform(Book $book)
    {
        return [
            'title'     => $book->getTitle(),
            'publisher' => $book->getPublisher(),
        ];
    }

    /**
     * @param Book $book
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeAuthor(Book $book)
    {
        return $this->item($book->getAuthor(), new AuthorTransformer());
    }
}
