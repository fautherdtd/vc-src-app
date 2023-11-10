<?php

namespace App\Facades;

use App\Services\Favorites\FavoritesFlowService;
use Illuminate\Support\Facades\Facade;

class Favorites extends Facade {

    protected static function getFacadeAccessor()
    {
        return FavoritesFlowService::class;
    }
}
