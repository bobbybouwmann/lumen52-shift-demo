<?php

namespace App\Http\Controllers;

use App\Author;
use App\Transformers\AuthorBookTransformer;
use App\Transformers\AuthorTransformer;
use App\Transformers\BookTransformer;
use Illuminate\Http\Request;

class AuthorsController extends ApiController
{
    protected $authorTransformer;

    public function __construct(AuthorTransformer $authorTransformer)
    {
        $this->authorTransformer = $authorTransformer;
    }

    public function index()
    {
        $authors = Author::all();

        return $this->respondWithData($this->authorTransformer->transformCollection($authors));
    }

    public function show($id)
    {
        $author = Author::find($id);

        if (! $author) {
            return $this->respondNotFound('Author does not exist.');
        }

        return $this->respondWithData($this->authorTransformer->transform($author));
    }

    public function books(AuthorBookTransformer $authorBookTransformer, $id)
    {
        $author = Author::with('books')->find($id);

        if (! $author) {
            return $this->respondNotFound('Author does not exist.');
        }

        $books = $author->books;

        return $this->respondWithData($authorBookTransformer->transformCollection($books));
    }

    public function store(Request $request)
    {
        $rules = [
            'name'     => 'required',
            'country'  => 'required',
            'birthday' => 'required',
        ];

        if ($this->validateApiRequestFails($request, $rules)) {
            return $this->respondValidationFailed();
        }

        Author::create($request->all());

        return $this->respondCreatedSuccessfully('Author successfully created');
    }

    public function update(Request $request, $id)
    {
        $author = Author::find($id);

        if (! $author) {
            return $this->respondNotFound('Author does not exist.');
        }

        $author->update($request->all());

        return $this->respondSuccess('Author successfully updated');
    }

    public function destroy($id)
    {
        $author = Author::find($id);

        if (! $author) {
            return $this->respondNotFound('Author does not exist.');
        }

        $author->delete();

        return $this->respondSuccess('Author successfully deleted');
    }
}
