<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice_cost_adjustments extends Model
{
     protected $fillable = [
      'received_id',
      'principal_id',
      'particulars',
      'total_invoice_adjusted',
      'total_bo_allowance',
      'vatable_purchase',
      'less_discount',
      'net_discount',
      'vat_amount',
      'net_adjustment',
      'date'


    ];

    public function received()
    {
    	return $this->belongsTo('App\Received_purchase_order', 'received_id');
    }

    public function invoice_cost_jer()
    {
      return $this->hasOne('App\Invoice_cost_adjustments_jer', 'invoice_cost_id');
    }


    public function principal()
    {
    	return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function invoice_cost_adjusments()
    {
      return $this->belongsTo('App\Invoice_cost_adjustments', 'invoice_cost_adjustment_id');
    }
}
