<?php

namespace App\Http\Controllers;

use App\Facades\Favorites;
use App\Http\Resources\Postcards\PostcardsResource;
use App\Http\Resources\Products\ProductsResources;
use App\Models\Product;
use App\Models\Postcards;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FavoritesController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        $items = Favorites::content()->groupBy('type');
        $postcards = [];
        $products = [];

        if (!empty($items['postcards'])) {
            $postcards = Postcards::whereIn('id', $items->get('postcards')
                ->pluck('id'))->get();
        }
        if (!empty($items['products'])) {
            $products =  Product::whereIn('id', $items->get('products')
                ->pluck('id'))->get();
        }
        return Inertia::render('Favorites', [
            'postcards' => new PostcardsResource($postcards),
            'products' => new ProductsResources($products),
        ]);
    }

    /**
     * Adds an item to cart.
     *
     * @param Request $request
     */
    public function add(Request $request)
    {
        Favorites::add($request->input('id'), $request->input('type'));
    }
}
