<?php

namespace App\Http\Controllers;

use App\Http\Resources\Categories\CategoriesResources;
use App\Http\Resources\Postcards\PostcardsResource;
use App\Http\Resources\Products\ProductsResources;
use App\Models\Category;
use App\Models\Postcards;
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
        return Inertia::render('Catalog', [
            'products' => $slug !== 'otkrytki' ?
                $this->prepareProducts($request, $slug) : $this->preparePostcards($request),
            'visiblePostcard' => $slug === 'otkrytki'
        ]);
    }

    /**
     * @param Request $request
     * @param string|null $slug
     * @return ProductsResources
     */
    public function prepareProducts(Request $request, string $slug = null): ProductsResources
    {
        $products = new Product();
        if (! is_null($slug)) {
            $products->whereHas('category', function ($q) use($slug) {
                $q->where('slug', $slug);
            });
        }

        if ($request->filled('sort')) {
            $products->orderBy($request->input('sort'), 'DESC');
        }

        return new ProductsResources($products->get());
    }

    /**
     * @param Request $request
     * @return PostcardsResource
     */
    public function preparePostcards(Request $request): PostcardsResource
    {
        $postcards = Postcards::all();
        return new PostcardsResource($postcards);
    }
}
