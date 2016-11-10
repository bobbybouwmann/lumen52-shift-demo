<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = ['title', 'description', 'published_at'];

    protected $dates = ['created_at', 'updated_at', 'published_at'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
