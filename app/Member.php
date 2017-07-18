<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /**
     * Get the group of current member
     */
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    /**
     * Get the usser
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
