<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfGroups = config('seeder.groups');
        factory(App\Group::class, $numberOfGroups)->create()->each(function ($property) {
            $property->save(factory(App\Group::class)->make()->toArray());
        });
    }
}
