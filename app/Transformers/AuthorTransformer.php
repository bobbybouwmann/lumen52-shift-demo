<?php

namespace App\Transformers;

class AuthorTransformer extends Transformer
{
    public function transform($author)
    {
        return [
            'id'       => $author->id,
            'name'     => $author->name,
            'country'  => $author->country,
            'birthday' => $author->birthday->format('Y-m-d'),
        ];
    }
}
