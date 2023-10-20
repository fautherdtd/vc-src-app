<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductResource;
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

    /**
     * @return ProductsResources
     * @throws \Exception
     */
    public function popular(): ProductsResources
    {
        $model = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->offset(random_int(0, 10))
            ->limit(4);
        return new ProductsResources($model->get());
    }

    /**
     * @param int $id
     * @return ProductResource
     */
    public function item(int $id): ProductResource
    {
        $model = Product::with('category')
            ->where('id', $id);
        return new ProductResource($model->first());
    }
}
