<?php

namespace App\Http\Controllers;

use App\Member;
use App\Bill;
use App\Payment\Payment;
use App\Http\Requests\StorePayment;
use App\Http\Requests\SplitPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $members = Auth::user()->memberships;
        return view('payment.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StorePayment  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePayment $request)
    {
        try {
            $payment = Payment::create($request->except('_token'));
            return redirect($payment->groupPath())
                ->with('flash', 'Your payment was created');
        } catch (\Exception $e) {
            return redirect()->back()
            ->withErrors('error');
        }
    }

    /**
     * Split all payments into transactions
     *
     * @param  App\Http\Requests\StorePayment  $request
     * @return \Illuminate\Http\Response
     */
    public function split(SplitPayment $request)
    {
        $now = new \Carbon\Carbon();
        $billName = $request['identifier'] ?? 'Bill of ' . $now->toFormattedDateString();
        $paymentIds = array_map('intval', explode(',', $request['paymentIds']));
        $memberIds = array_keys($request['memberIds']);
        $groupId = (int) $request['groupId'];
        try {
            $bill = new Bill();
            $bill->generateTransactionsFromPayments($billName, $paymentIds, $memberIds, $groupId);
        } catch (\Exception $e) {
            dd($e);
        }
        return redirect('/group/' . $groupId)
            ->with('flash', 'The payments were splitted!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return back();
    }
}
