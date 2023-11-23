<?php

namespace App\Orchid\Layouts\Banner;

use App\Models\Banners;
use App\Models\Category;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Alert;

class BannerListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'banner';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     * @throws \ReflectionException
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', 'Наименование')
                ->render(function (Banners $banner) {
                    return Link::make($banner->title)
                        ->route('platform.banner.edit', $banner);
                }),
            TD::make('type', 'Тип баннера'),
            TD::make('is_active', 'Активность')
                ->render(fn (Banners $banner) => $banner->is_active ? 'Да' : 'Нет'),
            TD::make('created_at', 'Создан')
                ->usingComponent(DateTimeSplit::class),
            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Banners $banner) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make(__('Редактировать'))
                            ->route('platform.banner.edit', $banner->id)
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
