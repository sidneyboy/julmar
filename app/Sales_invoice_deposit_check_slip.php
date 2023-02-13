<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_invoice_deposit_check_slip extends Model
{
    protected $fillable = [
        'customer_id',
        'file',
        'user_id',
    ];
}
