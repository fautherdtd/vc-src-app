<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosifloraOrder extends Model
{
    protected $table = 'posiflora_orders';

    protected $fillable = [
        'external_uid',
        'docNo',
        'amount',
        'status',
        'payment_url',
        'telegram_message_id',
    ];
}
