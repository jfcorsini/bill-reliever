<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['bill_id', 'debtor', 'creditor', 'value'];

    public function bill()
    {
        return $this->belongsTo('App\Bill');
    }

    public function debtor()
    {
        return $this->belongsTo('App\Member', 'debtor');
    }

    public function creditor()
    {
        return $this->belongsTo('App\Member', 'creditor');
    }

    public function belongsToAuthUser()
    {
        $userId = \Auth::user()->id;
        $debtorId = $this->debtor()->first()->user()->first()->id;
        $creditorId = $this->creditor()->first()->user()->first()->id;

        if ($userId == $debtorId || $userId == $creditorId) {
            return true;
        }
        return false;
    }
}
