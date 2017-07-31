<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PaymentTest extends TestCase
{
    public function test_a_user_can_create_a_payment()
    {
        $payment = factory('App\Payment')->raw();
        dd($payment);

        // $this->post('/payments')
    }
}
