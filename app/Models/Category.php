<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use AsSource, HasSlug, Attachable;

    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
        'position',
        'is_visible',
        'seo_title',
        'seo_description',
        'is_deactivation'
    ];
    protected $casts = [
        'is_visible' => 'boolean',
        'is_deactivation' => 'boolean',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
