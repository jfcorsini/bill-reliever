<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::latest()->get();
        return view('group.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()) {
            return Redirect::route('group.index');
        }
        return view('group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()) {
            return Redirect::route('group.index');
        }

        $this->validate($request, [
            'name'      => 'required',
            'description'    => 'required',
        ]);

        $group = new Group();
        $group->name = $request->name;
        $group->description = $request->description;
        $group->save();

        $newMember = new \App\Member();
        $newMember->group_id = $group->id;
        $newMember->user_id = Auth::user()->id;
        $newMember->owner = true;
        $newMember->save();

        return redirect('group');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $users = $group->users();

        $payments = $group->payments();

        $userBelongsToGroup = false;
        if (Auth::user() && Auth::user()->isInGroup($group)) {
            $userBelongsToGroup = true;
        }
        return view('group.show', compact('group', 'users', 'payments', 'userBelongsToGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }
}
