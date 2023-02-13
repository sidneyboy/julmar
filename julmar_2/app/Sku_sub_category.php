<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku_sub_category extends Model
{
    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];
}
