<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer_to_bran_details extends Model
{
     protected $fillable = [
          'transfer_id',
          'sku_id',
          'quantity',
          'final_unit_cost',
     ];

     public function sku()
     {
          return $this->belongsTo('App\Sku_add', 'sku_id');
     }

     public function transfer()
     {
          return $this->belongsTo('App\transfer_to_branch', 'transfer_id');
     }
}
