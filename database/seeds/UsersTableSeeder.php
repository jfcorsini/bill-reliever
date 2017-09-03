<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'name' => "Joao",
            "email" => "jf.corsini@gmail.com",
            "password" => bcrypt('q1w2e3')
        ]);

        $numberOfUsers = config('seeder.users') - 1;

        factory(App\User::class, $numberOfUsers)->create()->each(function ($property) {
            $property->save(factory(App\User::class)->make()->toArray());
        });
    }
}
