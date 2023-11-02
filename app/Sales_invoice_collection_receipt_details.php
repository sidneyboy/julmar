<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_invoice_collection_receipt_details extends Model
{
    protected $fillable = [
        'sicrd_id',
        'si_id',
        'ar_balance',
        'amount_collected',
        'outstanding_balance',
        'remarks',
        'payment_status',
    ];

    public function sales_invoice()
    {
        return $this->belongsTo('App\Sales_invoice', 'si_id','id')->select('delivery_receipt');
    }
}
