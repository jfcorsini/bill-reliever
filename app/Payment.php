<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $fillable = ['member_id', 'value', 'description'];

    public function groupPath()
    {
        $group_id = Member::find($this->member_id)->group->id;
        return 'group/' . $group_id;
    }

    public function creator()
    {
        return Member::find($this->member_id)->user->name;
    }
}
