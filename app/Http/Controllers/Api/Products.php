<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductsResources;
use App\Models\Product;
use Illuminate\Http\Request;

class Products extends Controller
{

    /**
     * @param Request $request
     * @return ProductsResources
     */
    public function index(Request $request): ProductsResources
    {
        $model = Product::where('is_active', true);

        if ($request->filled('slug')) {
            $model->where('category.slug', $request->input('slug'));
        }

        if ($request->filled('slug')) {
            $model->orderBy($request->input('sort'), 'DESC');
        }

        return new ProductsResources($model->get());
    }
}
