<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bad_order_draft extends Model
{
    protected $fillable = [
        'sku_id',
        'quantity',
        'user_id',
    ];

    public function sku()
    {
        return $this->belongsTo('App\Sku_add', 'sku_id');
    }
}
