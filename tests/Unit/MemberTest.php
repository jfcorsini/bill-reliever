<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MemberTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_has_an_user()
    {
        $member = factory('App\Member')->create();

        $this->assertInstanceOf('App\User', $member->user);
    }
}
