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
}
