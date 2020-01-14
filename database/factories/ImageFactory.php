<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Image, User};
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create(),
        'body' => $faker->sentence,
        'image' => 'image.jpg',
    ];
});
