<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
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
        $users = [];
        foreach ($this->members as $member) {
            $users[] = $member->user;
        }
        return $users;
    }

    /**
     * Check if group received is the same
     */
    public function isSame(Group $group)
    {
        return $this->id == $group->id;
    }
}
