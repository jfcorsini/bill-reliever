<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;

class TransactionController extends Controller
{
    public function pay(Transaction $transaction)
    {
        if (!$transaction->belongsToAuthUser()) {
            return false;
        }

        try {
            $transaction->paid = true;
            $transaction->save();
            dd($transaction);
            return back();
        } catch (\Exception $e) {
            return false;
        }
    }
}
