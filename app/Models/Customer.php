<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Customer extends Model
{
    use AsSource;

    protected $table = 'customers';
    protected $fillable = [
        'name',
        'phone',
    ];
}
