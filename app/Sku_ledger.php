<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku_ledger extends Model
{
   protected $fillable = [
      'sku_id',
      'quantity',
      'running_balance',
      'user_id',
      'transaction_type',
      'all_id',
    ];

    public function sku()
    {
      return $this->belongsTo('App\Sku_add', 'sku_id');
    }

    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }
}
