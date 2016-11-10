<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class BooksControllerTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function test_if_it_fetch_some_books()
    {
        $books = factory(\App\Book::class, 2)->create();

        $this->get('/api/v1/books')
            ->seeJson([
                'title'        => $books->first()->title,
                'body'         => $books->first()->description,
                'published_at' => $books->first()->published_at->format('Y-m-d'),
            ]);
    }

    public function test_if_it_fetch_a_single_book()
    {
        $book = factory(\App\Book::class)->create();

        $this->get('/api/v1/books/' . $book->id)
            ->seeJson([
                'title'        => $book->title,
                'body'         => $book->description,
                'published_at' => $book->published_at->format('Y-m-d'),
            ]);
    }

    public function test_if_it_shows_an_error_message_for_not_found_book()
    {
        $this->get('/api/v1/books/99')
            ->seeJson([
                'error' => [
                    'message'     => 'Book does not exist.',
                    'status_code' => 404,
                ],
            ]);
    }

    public function test_if_it_can_create_a_new_book()
    {
        $data = factory(\App\Book::class)->make();

        $this->post('/api/v1/books', $data->toArray());

        $this->seeInDatabase('books', [
            'title'       => $data->title,
            'description' => $data->description,
        ]);

        $this->seeJson([
            'message' => 'Book successfully created'
        ]);
    }

    public function test_if_it_can_update_an_book()
    {
        $book = factory(\App\Book::class)->create();

        $this->patch('/api/v1/books/' . $book->id, [
            'title' => 'Lorem Ipsum',
        ]);

        $this->seeInDatabase('books', [
            'id'    => $book->id,
            'title' => 'Lorem Ipsum',
        ]);

        $this->seeJson([
            'message' => 'Book successfully updated'
        ]);
    }

    public function test_if_it_can_delete_an_book()
    {
        $book = factory(\App\Book::class)->create();

        $this->delete('/api/v1/books/' . $book->id);

        $this->notSeeInDatabase('books', [
            'id'    => $book->id,
            'title' => $book->title,
        ]);

        $this->seeJson([
            'message' => 'Book successfully deleted'
        ]);
    }
}
