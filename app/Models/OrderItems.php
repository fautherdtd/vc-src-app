<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use App\Models\Product;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
