<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = ['name', 'api_token'];

    protected $dates = ['created_at', 'updated_at'];
}