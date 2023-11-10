<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'uuid',
        'amount',
        'payment_method',
        'order_id'
    ];
}
