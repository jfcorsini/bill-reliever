<?php

$factory->define(App\Payment\Payment::class, function (Faker\Generator $faker) {
    return [
        'member_id' => \App\Member::all('id')->random()->id,
        'description' => $faker->paragraph,
        'value' => $faker->randomFloat(2, 0.01, 1000),
    ];
});
