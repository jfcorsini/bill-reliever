<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $memberIds = $user->memberIds();
        $debtors = \App\Transaction::whereIn('debtor', $memberIds)
            ->where('paid', false)
            ->with(['bill', 'debtor', 'debtor.user', 'creditor', 'creditor.user'])
            ->get()
            ->toArray();

        $creditors = \App\Transaction::whereIn('creditor', $memberIds)
            ->where('paid', false)
            ->with(['bill', 'debtor', 'debtor.user', 'creditor', 'creditor.user'])
            ->get()
            ->toArray();

        return view('user.show', compact('user', 'debtors', 'creditors'));
    }
}
