<?php

namespace App\Http\Controllers;

use App\Http\Resources\Categories\CategoriesResources;
use App\Http\Resources\Products\ProductsResources;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CatalogController extends Controller
{
    /**
     * @param Request $request
     * @param string|null $slug
     * @return Response
     */
    public function index(Request $request, string $slug = null): Response
    {
        $categories = Category::where('is_visible', true)
            ->orderBy('position', 'DESC');

        $products = Product::where('is_active', true);

        if (! is_null($slug)) {
            $products->whereHas('category', function ($q) use($slug) {
                $q->where('slug', $slug);
            });
        }

        if ($request->filled('sort')) {
            $products->orderBy($request->input('sort'), 'DESC');
        }

        return Inertia::render('Catalog', [
            'categories' => new CategoriesResources($categories->get()),
            'products' => new ProductsResources($products->get())
        ]);
    }
}
