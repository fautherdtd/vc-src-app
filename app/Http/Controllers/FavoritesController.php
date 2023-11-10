<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Facades\Favorites;
use App\Http\Resources\Products\ProductsResources;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FavoritesController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        $favorites = Product::where('is_active', true)
            ->whereIn('id', Favorites::content()->toArray());
        return Inertia::render('Favorites', [
            'favorites' => new ProductsResources($favorites->get())
        ]);
    }

    /**
     * Adds an item to cart.
     *
     * @param Request $request
     */
    public function add(Request $request)
    {
        Favorites::add($request->input('id'));
    }
}
