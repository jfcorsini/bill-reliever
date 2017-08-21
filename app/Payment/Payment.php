<?php

namespace App\Payment;

use Illuminate\Database\Eloquent\Model;
use App\Member;

class Payment extends Model
{
	protected $fillable = ['member_id', 'value', 'description'];

    public function groupPath()
    {
        $groupId = Member::find($this->member_id)->group->id;
        return 'group/' . $groupId;
    }

    public function creator()
    {
        return Member::find($this->member_id)->user->name;
    }
}