<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cm_for_bo extends Model
{
    protected $fillable = [
        'customer_id',
        'agent_id',
        'pcm_number',
        'pcm_upload_id',
        'sales_order_printed_id',
        'total_bo_amount',
        'total_customer_discount',
        'status',
        'converted_by',
        'posted_by',
        'date_confirmed',
        'date_posted',
        'personnels_involved',
        'amount_involved',
        'involved_in',
    ];

    public function customer()
    {
        return $this->belongsTo('App\customer', 'customer_id');
    }

    public function agent()
    {
        return $this->belongsTo('App\Agent', 'agent_id');
    }

    public function sales_order_print()
    {
        return $this->belongsTo('App\sales_order_print', 'sales_order_printed_id');
    }

     public function cm_for_bo_details()
    {
        return $this->hasMany('App\cm_for_bo_details', 'cm_for_bo_id');
    }

    //  public function personnel()
    // {
    //     return $this->belongsTo('App\personnel_add', 'personnel_id');
    // }

   

}
