<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pcm_upload_vs extends Model
{
    protected $fillable = [
    	'bo_rgs_export_code',
    	'customer_id',
    	'rgs_status',
    	'bo_status',
    ];
}
