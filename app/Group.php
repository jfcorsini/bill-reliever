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
        $memberIds = $this->getMembersIds();
        return \App\Payment\Payment::getPaginatorForMembers($memberIds);
    }

    /**
     * Return an array containing the ids of the members from the group
     *
     * @return array
     */
    private function getMembersIds()
    {
        return $this->members->map(function ($member) {
            return $member->id;
        })->toArray();
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

    public function getAssociativeMemberIdAndUserName()
    {
        return $this->members()
            ->get()
            ->mapWithKeys(function ($member) {
                return [$member['id'] => $member->user()->first()->name];
            })->toArray();
    }
}
