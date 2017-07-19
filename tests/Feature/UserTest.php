<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_anyone_can_see_a_user_profile()
    {
        $user = factory('App\User')->create();

        $response = $this->get('/user/' . $user->id);

        $response->assertSee($user->name);
    }
}
