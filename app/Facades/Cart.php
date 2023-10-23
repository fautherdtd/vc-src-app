<?php

namespace App\Facades;

use App\Services\Cart\CartFlowService;
use Illuminate\Support\Facades\Facade;

class Cart extends Facade {

    protected static function getFacadeAccessor()
    {
        return CartFlowService::class;
    }
}
