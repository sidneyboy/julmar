<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer_to_bran extends Model
{
    protected $fillable = [
        'received_id',
        'principal_id',
        'user_id',
        'transfer_from',
        'transfer_to',
        'total_amount',
    ];

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function user()
    {
        return $this->belongsTo('App\user', 'user_id');
    }

    public function received_purchase_order()
    {
        return $this->belongsTo('App\Received_purchase_order', 'received_id');
    }

    public function transfer_details()
    {
        return $this->hasMany('App\Transfer_to_branch_details', 'transfer_id');
    }
}
