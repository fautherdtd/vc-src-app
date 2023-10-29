<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class FAQ extends Model
{
    use AsSource;

    /**
     * @var string $table
     */
    protected $table = 'faq';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'content'
    ];
}
