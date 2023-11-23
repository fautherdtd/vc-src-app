<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;

class Banners extends Model
{
    use AsSource, Attachable;
    protected $table = 'banners';
    protected $fillable = [
        'title',
        'type',
        'link',
        'is_active'
    ];

    protected $casts = [
        'is_active'
    ];
}
