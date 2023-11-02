<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_invoice_collection_receipt extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'agent_id',
        'check_ref_cash',
        'official_receipt',
        'bank',
        'payment_date',
    ];

    public function sales_invoice_collection_receipt_details()
    {
        return $this->hasOne('App\Sales_invoice_collection_receipt_details', 'id')->select('si_id','remarks','payment_status');
    }
}
