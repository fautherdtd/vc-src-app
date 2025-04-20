<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosifloraOrder extends Model
{
    protected $table = 'posiflora_orders';

    protected $fillable = [
        'uid',
        'docNo',
        'amount',
        'payment',
        'status',
    ];
}
