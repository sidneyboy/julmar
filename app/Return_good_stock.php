<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Return_good_stock extends Model
{
    protected $fillable = [
        'delivery_receipt',
        'user_id',
        'principal_id',
        'sku_type',
    ];
}
