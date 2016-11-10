<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AuthorsControllerTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function test_if_it_fetch_some_authors()
    {
        $authors = factory(\App\Author::class, 2)->create();

        $this->get('/api/v1/authors')
            ->seeJson([
                'name'     => $authors->last()->name,
                'country'  => $authors->last()->country,
                'birthday' => $authors->last()->birthday->format('Y-m-d'),
            ]);
    }

    public function test_if_it_fetch_a_single_author()
    {
        $author = factory(\App\Author::class)->create();

        $this->get('/api/v1/authors/' . $author->id)
            ->seeJson([
                'name'     => $author->name,
                'country'  => $author->country,
                'birthday' => $author->birthday->format('Y-m-d'),
            ]);
    }

    public function test_if_it_shows_an_error_message_for_not_found_author()
    {
        $this->get('/api/v1/authors/99')
            ->seeJson([
                'error' => [
                    'message'     => 'Author does not exist.',
                    'status_code' => 404,
                ],
            ]);
    }

    public function test_if_it_can_create_a_new_author()
    {
        $data = factory(\App\Author::class)->make();

        $this->post('/api/v1/authors', $data->toArray());

        $this->seeInDatabase('authors', [
            'name'    => $data->name,
            'country' => $data->country,
        ]);

        $this->seeJson([
            'message' => 'Author successfully created'
        ]);
    }

    public function test_if_it_can_update_an_author()
    {
        $author = factory(\App\Author::class)->create();

        $this->patch('/api/v1/authors/' . $author->id, [
            'name' => 'Jane Doe',
        ]);

        $this->seeInDatabase('authors', [
            'id'      => $author->id,
            'country' => $author->country,
        ]);

        $this->seeJson([
            'message' => 'Author successfully updated'
        ]);
    }

    public function test_if_it_can_delete_an_author()
    {
        $author = factory(\App\Author::class)->create();

        $this->delete('/api/v1/authors/' . $author->id);

        $this->notSeeInDatabase('authors', [
            'id'      => $author->id,
            'country' => $author->country,
        ]);

        $this->seeJson([
            'message' => 'Author successfully deleted'
        ]);
    }
}