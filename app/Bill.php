<?php

namespace App;

use App\Payment\Splitter;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
	protected $fillable = ['name', 'value'];

    public static function createWithTransactions($name, $paymentIds, $memberIds, $groupId)
    {
        $splitter = new Splitter($paymentIds, $memberIds, $groupId);

        $bill = Bill::create([
            'name'  => $name,
            'value' => $splitter->getSplittedValue()
        ]);

        $transactions = $splitter->split($bill);

        foreach ($transactions as $transaction) {
            $data = $transaction + ['bill_id' => $bill->id];
            Transaction::create($data);
        }
    }
}
