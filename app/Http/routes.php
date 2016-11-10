<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->welcome();
});

$app->group(['prefix' => 'api/v1', 'middleware' => 'auth'], function ($app) {

    $app->get('authors', 'App\Http\Controllers\AuthorsController@index');
    $app->get('authors/{id}', 'App\Http\Controllers\AuthorsController@show');
    $app->get('authors/{id}/books', 'App\Http\Controllers\AuthorsController@books');
    $app->post('authors', 'App\Http\Controllers\AuthorsController@store');
    $app->patch('authors/{id}', 'App\Http\Controllers\AuthorsController@update');
    $app->delete('authors/{id}', 'App\Http\Controllers\AuthorsController@destroy');

    $app->get('books', 'App\Http\Controllers\BooksController@index');
    $app->get('books/{id}', 'App\Http\Controllers\BooksController@show');
    $app->post('books', 'App\Http\Controllers\BooksController@store');
    $app->patch('books/{id}', 'App\Http\Controllers\BooksController@update');
    $app->delete('books/{id}', 'App\Http\Controllers\BooksController@destroy');
});
