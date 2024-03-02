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
      'principal_id',
      'sku_type',
      'remarks',
      'adjustments',
      'amount',
      'running_amount',
      'final_unit_cost',
      'with_invoice_quantity',
      'with_invoice_net_balance',
      'date',
      'time',
    ];

    public function sku()
    {
      return $this->belongsTo('App\Sku_add', 'sku_id');
    }

    public function principal()
    {
      return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }
}
