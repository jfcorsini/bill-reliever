<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MemberTest extends TestCase
{
    use DatabaseMigrations;

    public function testItHasAnUser()
    {
        $group = factory('App\Group')->create();
        $user = factory('App\User')->create();
        $member = factory('App\Member')->create();

        $this->assertInstanceOf('App\User', $member->user);
    }
}
