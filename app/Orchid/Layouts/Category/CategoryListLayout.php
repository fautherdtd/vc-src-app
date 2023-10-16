<?php

namespace App\Orchid\Layouts\Category;

use App\Models\Category;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Alert;

class CategoryListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'categories';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', 'Наименование')
                ->render(function (Category $category) {
                    return Link::make($category->name)
                        ->route('platform.category.edit', $category);
                }),
            TD::make('slug', 'Slug'),
            TD::make('is_visible', 'Включен')
                ->render(fn (Category $category) => $category->is_visible ? 'Да' : 'Нет'),
            TD::make('created_at', 'Создан')
                ->usingComponent(DateTimeSplit::class),
            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Category $category) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make(__('Редактировать'))
                            ->route('platform.category.edit', $category->id)
                            ->icon('bs.pencil'),
                    ])),
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
