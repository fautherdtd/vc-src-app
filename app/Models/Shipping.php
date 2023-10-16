<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Shipping extends Model
{
    use AsSource;

    protected $table = 'shipping';
    protected $fillable = [
        'label',
        'method',
        'is_active'
    ];
    protected $casts = [
        'is_active' => 'boolean'
    ];
}
