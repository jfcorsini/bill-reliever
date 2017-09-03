<?php

use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfGroups = config('seeder.groups');
        $usersPerGroup = config('seeder.users_per_group');

        for ($i = 0; $i < $usersPerGroup; $i++) {
            $groupId = $i + 1;
            for ($j = 0; $j < $numberOfGroups; $j++) {
                $userId = $numberOfGroups*$i + $j + 1;
                factory(App\Member::class)->create(['user_id' => $userId, 'group_id' => $groupId]);
            }
        }
    }
}
