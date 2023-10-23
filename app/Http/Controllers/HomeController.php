<?php

namespace App\Http\Controllers;

use App\Http\Resources\Products\ProductsResources;
use App\Models\Product;
use Inertia\Inertia;

class HomeController extends Controller
{

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $model = Product::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->offset(0)
            ->limit(4);

        return Inertia::render('Index', [
            'popular' => new ProductsResources($model->get())
        ]);
    }
}
