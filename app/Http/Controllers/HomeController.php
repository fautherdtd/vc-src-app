<?php

namespace App\Http\Controllers;

use App\Http\Resources\Categories\CategoryResource;
use App\Http\Resources\FAQ\FAQResources;
use App\Http\Resources\Products\ProductsResources;
use App\Models\Category;
use App\Models\FAQ;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $popular = Product::storageQty()
            ->where('is_active', true)
            ->orderBy('id', 'DESC')
            ->offset(0)
            ->limit(4);

        $faq = FAQ::orderBy('id', 'ASC')->get();

        $categories = Category::where('is_visible', true)
            ->inRandomOrder();

        return Inertia::render('Index', [
            'popular' => new ProductsResources($popular->get()),
            'faq' => new FAQResources($faq),
            'categories' => new CategoryResource($categories->first())
        ]);
    }
}
