<?php

/** @var Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        [
            'id' => Uuid::generate()->string,
            'name' => env('B_NAME'),
            'email' => env('B_EMAIL'),
            'phoneNumber' => env('B_NUMBER'),
            'pin' => random_int(10000, 50000),
            'superAdmin' => true,
            'email_verified_at' => now(),
            'password' => bcrypt(env('B_NUMBER')), // password
            'remember_token' => Str::random(10),
        ],
        [
            'id' => Uuid::generate()->string,
            'name' => 'System Account',
            'email' => 'dev.techguy@gmail.com',
            'phoneNumber' => '0713255791',
            'pin' => random_int(10000, 50000),
            'superAdmin' => true,
            'email_verified_at' => now(),
            'password' => bcrypt('0713255791'), // password
            'remember_token' => Str::random(10),
        ]
    ];
});
