<?php

namespace App;

use App\Payment\Splitter;
use App\Payment\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['name', 'value', 'group_id'];

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function generateTransactionsFromPayments($name, $paymentIds, $memberIds, $groupId)
    {
        try {
            \Log::debug('Starting the process to generate transactions from payments', [
                'groupId' => $groupId,
            ]);

            DB::beginTransaction();

            $splitter = $this->updateBill($name, $paymentIds, $memberIds, $groupId);
            $this->updatePayments($paymentIds);
            $this->createTransactions($splitter);

            DB::commit();
        } catch (\Exception $e) {
            \Log::critical('Problems while generating transactions', [
                'Exception' => json_encode($e),
            ]);
            DB::rollBack();
            return redirect('/group/' . $groupId)->with('flash', 'Problems to split payments. Try again.');
        }
    }

    private function updateBill($name, $paymentIds, $memberIds, $groupId)
    {
        $splitter = new Splitter($paymentIds, $memberIds, $groupId);

        $this->fill([
            'name'     => $name,
            'value'    => $splitter->getSplittedValue(),
            'group_id' => $groupId,
        ]);
        $this->save();

        return $splitter;
    }

    private function createTransactions($splitter)
    {
        $transactions = $splitter->split($this);

        foreach ($transactions as $transaction) {
            $data = $transaction + ['bill_id' => $this->id];
            Transaction::create($data);
        }
    }

    private function updatePayments($paymentIds)
    {
        Payment::whereIn('id', $paymentIds)
            ->update(['bill_id' => $this->id]);
    }
}
