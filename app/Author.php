<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'authors';

    protected $fillable = ['name', 'country', 'birthday'];

    protected $dates = ['created_at', 'updated_at', 'birthday'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}