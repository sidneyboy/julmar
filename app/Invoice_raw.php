<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice_raw extends Model
{
    protected $fillable = [
        'customer',
        'invoice_data',
        'delivery_receipt',
        'sales_representative',
        'sku_code',
        'description',
        'quantity',
        'sku_type',
        'principal',
        'remarks',
        'barcode',
        'release_date',
        'user_id',
        'final_quantity',
        'sku_id',
        'rgs',
        'bo',
    ];
}
