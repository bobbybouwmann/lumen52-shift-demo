<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ApiTokenTest extends TestCase
{
    use DatabaseTransactions;

    public function test_if_the_user_can_visit_a_protected_url_with_a_valid_api_token()
    {
        $user = factory(\App\User::class)->create();

        $this->get('/api/v1/books', [
            'api_token' => $user->api_token
        ])->seeStatusCode(200);
    }

    public function test_if_the_user_cant_visit_a_protected_url_with_an_invalid_api_token()
    {
        $user = factory(\App\User::class)->create();

        $this->get('/api/v1/books', [
            'api_token' => strrev($user->api_token),
        ])->see('Unauthorized. Invalid API token.')
            ->seeStatusCode(401);
    }

    public function test_if_the_user_cant_visit_a_protected_url_withhout_an_api_token()
    {
        $this->get('/api/v1/books')
            ->see('Unauthorized. An API token is required.')
            ->seeStatusCode(401);
    }
}
