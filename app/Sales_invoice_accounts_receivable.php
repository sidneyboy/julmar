<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_invoice_accounts_receivable extends Model
{
    protected $fillable = [
        'user_id',
        'principal_id',
        'customer_id',
        'transaction',
        'all_id',
        'debit_record',
        'credit_record',
        'running_balance',
    ];

    public function sales_invoice()
    {
        return $this->belongsTo('App\Sales_invoice', 'all_id')->select('delivery_receipt');
    }

    public function sales_invoice_collection_receipt()
    {
        return $this->belongsTo('App\Sales_invoice_collection_receipt', 'all_id')->select('official_receipt');
    }
}
