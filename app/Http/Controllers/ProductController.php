<?php

namespace App\Http\Controllers;

use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Products\ProductsResources;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    /**
     * @param string $slug
     * @return Response
     */
    public function index(string $slug): Response
    {
        $product = Product::with('category')
            ->where('slug', $slug);

        return Inertia::render('Product', [
            'product' => new ProductResource($product->first()),
            'popular' => $this->popular()
        ]);
    }

    /**
     * @return ProductsResources
     */
    public function popular(): ProductsResources
    {
        return new ProductsResources(
            Product::orderBy('id', 'DESC')
                ->offset(0)
                ->limit(4)
                ->get()
        );
    }
}
