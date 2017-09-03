<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * Get all payments from the group
     */
    public function payments()
    {
        $memberIds = $this->members->map(function ($member) {
            return $member->id;
        })->toArray();
        $payments = \App\Payment\Payment::whereIn('member_id', $memberIds)->paginate(10);
        return $payments;
    }

    /**
     * Get all members from the group
     */
    public function members()
    {
        return $this->hasMany('App\Member');
    }

    /**
     * Get all users from the group
     */
    public function users()
    {
        return $this->members->map(function ($member) {
            return $member->user;
        });
    }

    /**
     * Check if group received is the same
     */
    public function isSame(Group $group)
    {
        return $this->id == $group->id;
    }
}
