<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer_to_branch_jer extends Model
{
    protected $fillable = [
    	'received_id',
    	'principal_id',
    	'inventory_into_branch',
    	'inventory_out_origin'
    	'branch_name',
    ];
}
