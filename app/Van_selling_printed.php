<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_printed extends Model
{
    protected $fillable = [
    	'customer_id',
    	'principal_id',
    	'sales_order_number',
    	'mode_of_transaction',
    	'delivery_receipt',
    	'price_level',
        'remarks',
    	'date',
        'total_amount',
        'date_paid_or_cancelled',
        'sku_type',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id');
    }  
    
    public function van_selling_printed_details()
    {
        return $this->hasMany('App\Van_selling_printed_details', 'van_selling_printed_id');
    } 
}
