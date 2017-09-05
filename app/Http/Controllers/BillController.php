<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill;

class BillController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill, Request $request)
    {
        $group = $bill->group()->first();
        if (!\Auth::user() || !\Auth::user()->isInGroup($group)) {
            return redirect('/home')->with('flash', 'You cannot see this bill.');
        }

        $transactions = $bill->transactions()->get();
        $members      = $group->getAssociativeMemberIdAndUserName();

        if ($request->ajax()) {
            return view('bill._table', compact('bill', 'transactions', 'members'));
        }

        return view('bill.show', compact('bill', 'transactions', 'members'));
    }
}
