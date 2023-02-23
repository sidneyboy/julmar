<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice_draft_details extends Model
{
    protected $fillable = [
        'invoice_draft_id',
        'sku_id',
        'quantity',
        'unit_price',
        'line_discount',
        'quantity_out',
        'scanned_remarks',
    ];

    public function sku()
    {
        return $this->belongsTo('App\Sku_add', 'sku_id');
    }
}
