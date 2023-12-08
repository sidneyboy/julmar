<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction_entry extends Model
{
    protected $fillable = [
        'description',
        'account_name',
        'account_number',
        'transaction'
    ];
}
