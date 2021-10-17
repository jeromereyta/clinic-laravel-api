<?php

declare(strict_types=1);

use App\Database\Entities\User;
use App\Database\Interfaces\UserTypes;
use Illuminate\Support\Str;

/** @var \LaravelDoctrine\ORM\Testing\Factory $factory*/
$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name(),
        'email' => $faker->email,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'type' => UserTypes::ADMIN,
    ];
});
