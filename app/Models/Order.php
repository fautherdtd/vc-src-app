<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
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
        'notes',
        'anonymous',
        'address_sub'
    ];
    public $casts = [
        'anonymous' => 'bool',
        'buyer' => 'array',
        'recipient' => 'array',
        'delivery_time' => 'datetime',
        'address_sub' => 'array'
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

    /**
     * @return HasOne
     */
    public function shipping(): HasOne
    {
        return $this->hasOne(Shipping::class, 'method', 'shipping_method');
    }


    public function getBuildTimeSlotAttribute()
    {
        setlocale(LC_TIME, 'ru_RU.UTF-8');
        Carbon::setLocale('ru_RU');
        return Carbon::parse($this->delivery_time)->format('D d M Y H:i:s');
    }

}
