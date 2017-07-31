<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MemberTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_has_an_user()
    {
        $member = factory('App\Member')->create();

        $this->assertInstanceOf('App\User', $member->user);
    }
}
