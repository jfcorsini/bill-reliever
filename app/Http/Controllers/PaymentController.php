<?php

namespace App\Http\Controllers;

use App\Member;
use App\Payment\Payment;
use App\Http\Requests\StorePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
     * Display the specified resource.
     *
     * @param  \App\Payment\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
