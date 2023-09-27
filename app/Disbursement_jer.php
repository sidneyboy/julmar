<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disbursement_jer extends Model
{
    protected $fillable = [
        'principal_id',
        'debit_record',
        'credit_record',
        'disbursement_id',
    ];
}
