<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cm_for_rgs extends Model
{
    protected $fillable = [
    	'customer_id',
    	'sales_order_printed_id',
        'pcm_upload_id',
        'pcm_number',
    	'total_rgs_amount',
    	'agent_id',
    	'date_confirmed',
        'date_posted',
    	'status',
        'converted_by',
        'posted_by',
    ];

    public function customer()
    {
        return $this->belongsTo('App\customer', 'customer_id');
    }

    public function agent()
    {
        return $this->belongsTo('App\agent', 'agent_id');
    }

    public function sales_order_print()
    {
        return $this->belongsTo('App\sales_order_print', 'sales_order_printed_id');
    }

        public function cm_for_rgs_details()
    {
        return $this->hasMany('App\Cm_for_rgs_details', 'cm_for_rgs_id');
    }
}
