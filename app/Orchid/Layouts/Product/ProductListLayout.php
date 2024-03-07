<?php

namespace App\Orchid\Layouts\Product;

use App\Http\Controllers\Helpers\Images;
use App\Models\Category;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;

class ProductListLayout extends Table
{
    use Images;
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'products';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')
                ->width('100')
                ->render(function (Product $product) {
                    return "<span class='small text-muted mt-1 mb-0'># {$product->id}</span>";
                    }
                ),
            TD::make('preview', 'Изображение')->render(function (Product $item) {
                return "<img height='100px' src='{$this->getUrl($item->attachment('preview')->first())}'/>";
            }),
            TD::make('name', 'Наименование')
                ->render(function (Product $product) {
                    return Link::make($product->name)
                        ->route('platform.product.edit', $product);
                }),
            TD::make('slug', 'Slug'),
            TD::make('category.name', 'Категория')
                ->sort()
                ->render(function (Product $product) {
                    return "<span>" . $product->category->name . "</span>";
                }),
            TD::make('qty', 'Кол-во доступных'),
            TD::make('is_active', 'Активность')
                ->sort()
                ->render(function (Product $product) {
                    $text = $product->is_active ? "Да" : "Нет";
                    return "<span> $text </span>";
                }),
            TD::make('created_at', 'Создан')
                ->usingComponent(DateTimeSplit::class),
            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Product $product) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Button::make(__('Активность'))
                            ->icon('bs.eye-fill')
                            ->method('activeChange', [
                                'id' => $product->id,
                                'is_active' => $product->is_active
                            ]),

                        Link::make(__('Редактировать'))
                            ->route('platform.product.edit', $product->id)
                            ->icon('bs.pencil'),

                        Button::make(__('Удалить'))
                            ->icon('bs.trash3')
                            ->confirm(__('Удалить.'))
                            ->method('remove', [
                                'id' => $product->id,
                            ]),
                    ])),
        ];
    }
}
