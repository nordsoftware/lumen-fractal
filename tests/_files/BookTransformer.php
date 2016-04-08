<?php

namespace Nord\Lumen\Tests\Files;

use League\Fractal\TransformerAbstract;

/**
 * Class BookTransformer.
 *
 * @package Nord\Lumen\Tests\Files
 */
class BookTransformer extends TransformerAbstract
{

    /**
     * @param Book $book
     *
     * @return array
     */
    public function transform(Book $book)
    {
        return [
            'title'     => $book->getTitle(),
            'author'    => $book->getAuthor(),
            'publisher' => $book->getPublisher(),
        ];
    }
}
