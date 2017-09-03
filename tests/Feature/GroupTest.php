<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GroupTest extends TestCase
{
    use DatabaseMigrations;

    public function testAUserCanSeeAllGroups()
    {
        $group = factory('App\Group')->create();

        $response = $this->get('/group');

        $response->assertSee($group->name);
    }

    public function testMembersOfGroupCanSeeInsideAGroup()
    {
        $group = factory('App\Group')->create();
        $user = factory('App\User')->create();
        $member = factory('App\Member')->create(['user_id' => $user->id]);
        $group = $member->group;

        $this->signIn($user);
        $response = $this->get('/group/' . $group->id);
        $response->assertSee($member->group->name);
    }

    public function testUnasignedUsersCanOnlySeeBasicInfo()
    {
        $group = factory('App\Group')->create();
        $user = factory('App\User')->create();
        $member = factory('App\Member')->create();
        $group = $member->group;

        $response = $this->get('/group/' . $group->id);
        $response->assertDontSee($group->users()[0]->name);
    }

    public function testSignedUserNotFromTheGroupCanOnlySeeBasicInfo()
    {
        $group = factory('App\Group')->create();
        $user = factory('App\User')->create();
        $member = factory('App\Member')->create(['user_id' => $user->id]);
        $group = $member->group;

        $user = factory('App\User')->create();
        $this->signIn($user);

        $response = $this->get('/group/' . $group->id);
        $response->assertSee($group->description);
        $response->assertDontSee($group->users()[0]->name);
    }

    public function testAMemberCanSeeAllMembersInsideAGroup()
    {
        $group = factory('App\Group')->create();
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
