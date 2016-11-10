<?php

namespace App\Http\Controllers;

use App\Book;
use App\Transformers\BookTransformer;
use Illuminate\Http\Request;

class BooksController extends ApiController
{
    protected $bookTransformer;

    public function __construct(BookTransformer $bookTransformer)
    {
        $this->bookTransformer = $bookTransformer;
    }

    public function index()
    {
        $book = Book::with('author')->all();

        return $this->respondWithData($this->bookTransformer->transformCollection($book));
    }

    public function show($id)
    {
        $book = Book::with('author')->find($id);

        if (! $book) {
            return $this->respondNotFound('Book does not exist.');
        }

        return $this->respondWithData($this->bookTransformer->transform($book));
    }

    public function store(Request $request)
    {
        $rules = [
            'author_id'    => 'required',
            'title'        => 'required',
            'description'  => 'required',
            'published_at' => 'required',
        ];

        if ($this->validateApiRequestFails($request, $rules)) {
            return $this->respondValidationFailed();
        }

        Book::create($request->all());

        return $this->respondCreatedSuccessfully('Book successfully created');
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (! $book) {
            return $this->respondNotFound('Book does not exist.');
        }

        $book->update($request->all());

        return $this->respondSuccess('Book successfully updated');
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (! $book) {
            return $this->respondNotFound('Book does not exist.');
        }

        $book->delete();

        return $this->respondSuccess('Book successfully deleted');
    }
}
