<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PaymentTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_member_can_create_new_payments_within_group()
    {
        $member = factory('App\Member')->create();
        $this->signIn($member->user);

        $data = array(
            'value'       => '11.20',
            'description' => 'A piece of nail',
            'member_id'   => $member->id
        );

        $this->post('/payment', $data)
            ->assertRedirect('/group/' . $member->group_id);

        $this->get('group/' . $member->group_id)
            ->assertSee('A piece of nail');
    }

    public function test_unauthorized_users_cannot_create_payments()
    {
        $this->get('/payment/create')
            ->assertRedirect('/login');
    }
}
