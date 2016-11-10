<?php

namespace App\Transformers;

class AuthorBookTransformer extends Transformer
{
    public function transform($book)
    {
        return [
            'id'           => $book->id,
            'title'        => $book->title,
            'body'         => $book->description,
            'published_at' => $book->published_at->format('Y-m-d'),
            'author'       => [
                'name'     => $book->author->name,
                'country'  => $book->author->country,
                'birthday' => $book->author->birthday->format('Y-m-d'),
            ],
        ];
    }
}
