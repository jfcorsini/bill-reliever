<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $member = new Member([
                "group_id" => (int) $request['group_id'],
                "user_id"  => Auth::user()->id
            ]);
            $member->save();
            return redirect('/group/' . $request['group_id']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error');
        }
    }
}
