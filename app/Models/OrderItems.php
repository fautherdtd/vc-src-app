<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Screen\AsSource;

class OrderItems extends Model
{
    use AsSource;

    public $table = 'order_items';
    public $fillable = [
        'order_id',
        'product_id',
        'qty',
        'unit_price'
    ];

    /**
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
