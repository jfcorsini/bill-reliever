<?php

$factory->define(App\Member::class, function (Faker\Generator $faker) {
    return [
        'user_id'  => \App\User::all('id')->random()->id,
        'group_id' => \App\Group::all('id')->random()->id,
    ];
});
