<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse_out extends Model
{
    protected $fillable = [
        'principal_id',
        'user_id',
        'sales_invoice_id',
        'status',
    ];
}
