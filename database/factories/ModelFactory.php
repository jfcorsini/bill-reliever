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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Member::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'group_id' => function () {
            return factory('App\Group')->create()->id;
        },
    ];
});

$factory->define(App\Group::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->paragraph
    ];
});

$factory->define(App\Payment\Payment::class, function (Faker\Generator $faker) {
    return [
        'member_id' => function () {
            return factory('App\Member')->create()->id;
        },
        'description' => $faker->paragraph,
        'value' => $faker->numberBetween(1, 500),
    ];
});

$factory->define(App\Bill::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'value' => $faker->numberBetween(1, 500),
    ];
});
