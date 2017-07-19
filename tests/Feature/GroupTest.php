<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GroupTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_user_can_see_all_groups()
    {
        $group = factory('App\Group')->create();

        $response = $this->get('/group');

        $response->assertSee($group->name);
    }

    public function test_members_of_group_can_see_inside_a_group()
    {
        $user = factory('App\User')->create();
        $member = factory('App\Member')->create(['user_id' => $user->id]);
        $group = $member->group;

        $this->signIn($user);
        $response = $this->get('/group/' . $group->id);
        $response->assertSee($member->group->name);
    }

    public function test_unasigned_users_can_only_see_basic_info()
    {
        $member = factory('App\Member')->create();
        $group = $member->group;

        $response = $this->get('/group/' . $group->id);
        $response->assertDontSee($group->users()[0]->name);
    }

    public function test_signed_user_not_from_the_group_can_only_see_basic_info()
    {
        $user = factory('App\User')->create();
        $member = factory('App\Member')->create(['user_id' => $user->id]);
        $group = $member->group;

        $user = factory('App\User')->create();
        $this->signIn($user);

        $response = $this->get('/group/' . $group->id);
        $response->assertDontSee($group->users()[0]->name);
    }

    public function teste_a_member_can_see_all_members_inside_a_group()
    {
        $user = factory('App\User')->create();
        $member = factory('App\Member')->create(['user_id' => $user->id]);
        $group = $member->group;
        $members = factory('App\Member', 2)->create(["group_id" => $group->id]);

        $this->signIn($user);
        $response = $this->get('/group/' . $group->id);

        $response->assertSee($members[0]->user->name);
        $response->assertSee($members[1]->user->name);
    }
}
