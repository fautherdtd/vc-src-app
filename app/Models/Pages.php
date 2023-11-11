<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;

class Pages extends Model
{
    use AsSource, Attachable;

    protected $table = 'page';
    protected $fillable = [
        'title',
        'body',
        'slug',
        'seo_title',
        'seo_description'
    ];
}
