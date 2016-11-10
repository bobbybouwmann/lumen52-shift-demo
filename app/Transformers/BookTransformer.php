<?php

namespace App\Transformers;

class BookTransformer extends Transformer
{
    public function transform($book)
    {
        return [
            'id'           => $book->id,
            'title'        => $book->title,
            'body'         => $book->description,
            'published_at' => $book->published_at->format('Y-m-d'),
        ];
    }
}