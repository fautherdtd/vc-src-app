<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Screen\AsSource;

class Order extends Model
{
    use AsSource;
    public $table = 'orders';

    public $fillable = [
        'number',
        'customer_id',
        'total_price',
        'delivery_time',
        'address',
        'buyer',
        'recipient',
        'status',
        'shipping_price',
        'shipping_method',
        'payment_method',
        'notes'
    ];
    public $casts = [
        'buyer' => 'array',
        'recipient' => 'array',
        'delivery_time' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }

}
