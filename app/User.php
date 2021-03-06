<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * A user may be a member of many groups
     */
    public function memberships()
    {
        return $this->hasMany('App\Member');
    }

    /**
     * Get all groups of user
     */
    public function groups()
    {
        return $this->memberships->map(function ($membership) {
            return $membership->group;
        });
    }

    public function memberIds()
    {
        return $this->memberships
            ->map(function ($member) {
                return $member->id;
            })->toArray();
    }

    public function groupIds()
    {
        return $this->groups()
            ->map(function ($group) {
                return $group->id;
            })->toArray();
    }

    public function isInGroup($focusGroup)
    {
        foreach ($this->groups() as $group) {
            if ($focusGroup->isSame($group)) {
                return true;
            }
        }
        return false;
    }
}
