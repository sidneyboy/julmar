<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cm_for_rgs_jer extends Model
{
   protected $fillable = [
   		'cm_for_rgs_id',
   		'sales',
   		'accounts_receivable',
   		'inventory',
   		'cost_of_sales',
   ];
}
