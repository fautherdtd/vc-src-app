<?php

namespace App\Http\Middleware;

use App\Facades\Cart;
use App\Facades\Favorites;
use App\Http\Resources\Categories\CategoriesResources;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'share' => [
                'cart' => [
                    'totalQuantity' => Cart::totalQuantity(),
                    'totalPrice' => Cart::total(),
                    'content' => Cart::content()
                ],
                'favorites' => [
                    'totalQuantity' => Favorites::totalQuantity(),
                    'content' => Favorites::content()
                ],
                'categories' => new CategoriesResources(
                    Category::where('is_visible', true)
                        ->orderBy('position', 'DESC')->get()
                )
            ],
        ];
    }
}
