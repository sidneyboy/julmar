<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice_cost_adjustments_jer extends Model
{
     protected $fillable = [
      'invoice_cost_id',
      'dr',
      'cr',
      'date',
    ];

    public function invoice_cost_adjustments()
    {
    	return $this->belongsTo('App\invoice_cost_adjustments', 'invoice_cost_id');
    }
}
