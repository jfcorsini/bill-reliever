<?php

namespace App;

use App\Payment\Splitter;
use App\Payment\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    private $name;

    protected $fillable = ['name', 'value'];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function generateTransactionsFromPayments($paymentIds, $memberIds, $groupId)
    {
        try {
            \Log::debug('Starting the process to generate transactions from payments', [
                'groupId' => $groupId,
            ]);

            DB::beginTransaction();

            $splitter = $this->updateBill($paymentIds, $memberIds, $groupId);
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

    private function updateBill($paymentIds, $memberIds, $groupId)
    {
        $splitter = new Splitter($paymentIds, $memberIds, $groupId);

        $this->fill([
            'name'  => $this->name,
            'value' => $splitter->getSplittedValue()
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
