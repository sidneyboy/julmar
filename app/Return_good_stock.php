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

    public function return_good_stock_details()
    {
        return $this->hasMany('App\Return_good_stock_details', 'return_good_stock_id');
    }

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id');
    }
}
