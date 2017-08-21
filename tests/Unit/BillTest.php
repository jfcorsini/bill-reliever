<?php

namespace Tests\Unit;

use App\Bill;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BillTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_new_bill_of_one_transaction()
    {
        $billName = "September of 2018";
        $bill = factory('App\Bill')->create();
        $group = factory('App\Group')->create();
        $members = factory('App\Member', 5)->create(['group_id' => $group->id]);
        $payments = [
            factory('App\Payment\Payment')->create(['member_id' => $members[0]->id, 'value' => 50]),
        ];

        $paymentIds = array_map(function($payment) {
            return $payment->id;
        }, $payments);

        $memberIds = array_map(function($member) {
            return $member['id'];
        }, $members->toArray());

        Bill::createWithTransactions($billName, $paymentIds, $memberIds, $group->id);

        $this->assertDatabaseHas('bills',[
            'name' => $billName
        ]);

        $this->assertDatabaseHas('transactions',[
            'debtor'   => 2,
            'creditor' => 1,
            'value'    => 10
        ]);
        $this->assertDatabaseHas('transactions',[
            'debtor'   => 3,
            'creditor' => 1,
            'value'    => 10
        ]);
        $this->assertDatabaseHas('transactions',[
            'debtor'   => 4,
            'creditor' => 1,
            'value'    => 10
        ]);
        $this->assertDatabaseHas('transactions',[
            'debtor'   => 5,
            'creditor' => 1,
            'value'    => 10
        ]);
    }

    public function test_simple_splitting_one_payment_in_five()
    {
        $billName = "September of 2018";
        $group = factory('App\Group')->create();
        $members = factory('App\Member', 3)->create(['group_id' => $group->id]);
        $payments = [
            factory('App\Payment\Payment')->create(['member_id' => $members[0]->id, 'value' => 10]),
            factory('App\Payment\Payment')->create(['member_id' => $members[1]->id, 'value' => 20]),
            factory('App\Payment\Payment')->create(['member_id' => $members[2]->id, 'value' => 30]),
        ];

        $paymentIds = array_map(function($payment) {
            return $payment->id;
        }, $payments);

        $memberIds = array_map(function($member) {
            return $member['id'];
        }, $members->toArray());

        Bill::createWithTransactions($billName, $paymentIds, $memberIds, $group->id);

        $this->assertDatabaseHas('transactions',[
            'debtor'   => 1,
            'creditor' => 3,
            'value'    => 10
        ]);
    }
}
