<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Transactions extends Model
{
    use AsSource;
    
    protected $table = 'transactions';
    protected $fillable = [
        'uuid',
        'amount',
        'payment_method',
        'order_id'
    ];
}
