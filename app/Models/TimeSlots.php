<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class TimeSlots extends Model
{
    use AsSource;

    protected $table = 'time_slots';
    protected $fillable = [
        'title',
        'type',
        'slots',
        'is_active'
    ];

    protected $casts = [
        'slots' => 'array',
        'is_active' => 'boolean'
    ];
}
