<?php

namespace App\Http\Controllers;

use App\{Payment, Member};
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $member_id = $request['member_id'] ?? null; 
        $member    = Member::find($member_id);
        if ($member->user_id != Auth::user()->id) {
            return redirect()->back(); 
        }

        $this->validate($request, [
            'member_id' => 'required',
            'description' => 'required',
            'value' => 'required',
        ]);

        try {
            $payment = new Payment([
                "member_id"   => (int) $request['member_id'],
                "description" => $request['description'],
                "value"       => $request['value'],
            ]);

            $payment->save();

            return redirect($payment->groupPath());
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
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
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
