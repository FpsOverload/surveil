<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Server::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->domainWord,
        'path' => base_path(),
        'binary' => 'artisan test:server',
        'game' => 'cod4x',
        'ip' => '127.0.0.1',
        'port' => '28960',
        'rcon' => str_random(8),
        'default_params' => '+exec server.cfg +map mp_crossfire'
    ];
});
