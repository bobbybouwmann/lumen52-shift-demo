<?php

namespace App\Transformers;

use Illuminate\Support\Collection;

abstract class Transformer
{
    abstract public function transform($item);

    public function transformCollection(Collection $items)
    {
        return $items->map(function ($item) {
            return $this->transform($item) ;
        });
    }
}
