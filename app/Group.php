<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * Get the member of the group
     */
    public function member()
    {
        return $this->hasOne('App\Member');
    }
}
