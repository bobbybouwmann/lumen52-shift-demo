<?php

$factory->define(App\User::class, function ($faker) {
    return [
        'name'      => $faker->name,
        'api_token' => str_random(10),
    ];
});

$factory->define(App\Author::class, function ($faker) {
    return [
        'name'     => $faker->name,
        'country'  => $faker->country,
        'birthday' => $faker->date('Y-m-d', '-10 years'),
    ];
});

$factory->define(App\Book::class, function ($faker) {
    return [
        'author_id'    => factory(App\Author::class)->create()->id,
        'title'        => $faker->sentence,
        'description'  => $faker->paragraph,
        'published_at' => $faker->date,
    ];
});
