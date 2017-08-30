<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PaymentTest extends TestCase
{
    use DatabaseMigrations;

    public function testAMemberCanCreateNewPaymentsWithinGroup()
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

    public function testUnauthorizedUsersCannotCreatePayments()
    {
        $this->get('/payment/create')
            ->assertRedirect('/login');
    }
}
