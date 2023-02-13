<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pcm_upload extends Model
{
    protected $fillable = [
    	'bo_rgs_export_code',
    	'agent_id',
    	'customer_id',
    	'principal_id',
    	'delivery_receipt',
    	'date',
    	'rgs_status',
    	'bo_status',
        'returned_by',
    ];

    public function agent()
    {
        return $this->belongsTo('App\Agent', 'agent_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function pcm_upload_details()
    {
        return $this->hasMany('App\Pcm_upload_details', 'pcm_upload_id');
    }

}
