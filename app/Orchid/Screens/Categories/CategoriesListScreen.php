<?php

namespace App\Orchid\Screens\Categories;

use App\Models\Category;
use App\Models\Product;
use App\Orchid\Layouts\Category\CategoryListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class CategoriesListScreen extends Screen
{
    /**
     * Display header name
     *
     * @var string
     */
    public $name = 'Категории';

    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'Категории продукции';
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'categories' => Category::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить категорию')
                ->icon('pencil')
                ->route('platform.category.create')
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
            CategoryListLayout::class
        ];
    }


    /**
     * @param Category $category
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Category $category): \Illuminate\Http\RedirectResponse
    {
        $category->delete();
        Alert::info('Категория удалена.');
        return redirect()->route('platform.category.list');
    }
}
