<?php

namespace Nord\Lumen\Tests\Files;

use League\Fractal\TransformerAbstract;

/**
 * Class AuthorTransformer.
 */
class AuthorTransformer extends TransformerAbstract
{
    /**
     * @param Author $author
     *
     * @return array
     */
    public function transform(Author $author)
    {
        return [
            'firstName' => $author->getFirstName(),
            'lastName'  => $author->getLastName(),
        ];
    }
}
