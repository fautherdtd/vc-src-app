<?php

namespace App\Orchid\Screens\Products;

use App\Models\Product;
use App\Orchid\Filters\CategoryFilter;
use App\Orchid\Layouts\Product\ProductFiltersLayout;
use App\Orchid\Layouts\Product\ProductListLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class ProductListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'products' => Product::with('category')
                ->filters([CategoryFilter::class])
                ->defaultSort('id', 'desc')->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Продукция';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить продукт')
                ->icon('pencil')
                ->route('platform.product.create')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ProductFiltersLayout::class,
            ProductListLayout::class
        ];
    }

    /**
     * @param Product $product
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Product $product): \Illuminate\Http\RedirectResponse
    {
        $product->delete();
        Alert::info('Продукт удален.');
        return redirect()->route('platform.product.list');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function activeChange(Request $request)
    {
        $product = Product::where('id', $request->input('id'))
            ->update(['is_active' => !$request->input('is_active')]);
        Alert::info('Активность изменена');
        return redirect()->route('platform.product.list');
    }
}
