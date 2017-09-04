<?php

namespace App\Payment;

use Illuminate\Database\Eloquent\Model;
use App\Member;

class Payment extends Model
{
    protected $fillable = ['member_id', 'value', 'description', 'bill_id'];

    public function groupPath()
    {
        $groupId = $this->group()->id;
        return 'group/' . $groupId;
    }

    public function creator()
    {
        return Member::find($this->member_id)->user->name;
    }

    public function group()
    {
        return Member::find($this->member_id)->group;
    }

    /**
     * Returns a paginator for all payments with member_id in the array $memberIds
     *
     * @param array $memberIds
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginatorForMembers($memberIds)
    {
        return self::whereIn('member_id', $memberIds)
            ->orderByDesc('id')
            ->paginate(10);
    }

    /**
     * Returns a boolean to indicate if the payments was splitted into a bill
     *
     * @return boolean
     */
    public function hasBill()
    {
        return !is_null($this->bill_id);
    }

    /**
     * Returns the Bill object of this payment
     * 
     * @return App\Bill
     */
    public function bill()
    {
        return $this->belongsTo('App\Bill')->first();
    }
}
