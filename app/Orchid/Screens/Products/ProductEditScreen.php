<?php

namespace App\Orchid\Screens\Products;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ProductEditScreen extends Screen
{
    public $product;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Product $product): iterable
    {
        $product->load('attachment');
        return [
            'product' => $product
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->product->exists ?
            'Редактирование продукты' : 'Создание нового продукта';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->icon('bs.plus-circle')
                ->method('save')
                ->canSee(!$this->product->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('save')
                ->canSee($this->product->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->product->exists),
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
            Layout::columns([
                Layout::rows([
                    Input::make('product.name')
                        ->required()
                        ->title('Наименование'),
                    TextArea::make('product.description')
                        ->rows(5)
                        ->required()
                        ->placeholder('Описание продукта')
                        ->title('Описание'),
                    Select::make('product.category_id')
                        ->required()
                        ->placeholder('Выберите категорию')
                        ->title('Категория')
                        ->fromModel(Category::class, 'name'),
                    TextArea::make('product.compound')
                        ->rows(5)
                        ->required()
                        ->placeholder('Состав продукта')
                        ->title('Состав продукта'),
                ])->title('Информация'),

                Layout::rows([
                    Input::make('product.price')
                        ->required()
                        ->title('Цена'),
                    Input::make('product.seo_title')
                        ->required()
                        ->title('SEO заголовок'),
                    Input::make('product.seo_description')
                        ->required()
                        ->title('SEO описание'),
                    CheckBox::make('is_active')
                        ->value(1)
                        ->title('Активность')
                        ->placeholder('Отобразить товар')
                ])->title('Доп информация'),
            ]),
            Layout::columns([
                Layout::rows([
                    Matrix::make('product.chars')
                        ->columns([
                            'Название',
                            'Значение',
                        ]),
                ])->title('Характеристики'),
                Layout::rows([
                    Matrix::make('product.modify')
                        ->columns([
                            'Кол-во цветов',
                            'Цена',
                        ]),
                ])->title('Модификации букета'),
            ]),
            Layout::columns([
                Layout::rows([
                    Upload::make('product.preview')
                        ->groups('preview')
                        ->maxFiles(1)
                ])->title('Основное изображение'),
                Layout::rows([
                    Upload::make('product.gallery')
                        ->groups('gallery')
                ])->title('Изображения для галереи'),
            ])
        ];
    }

    /**
     * @param Product $product
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Product $product, Request $request): \Illuminate\Http\RedirectResponse
    {
        $product->fill(
            $request->get('product')
        )->save();
        $product->attachment()->syncWithoutDetaching(
            $request->input('product.preview', [])
        );
        $product->attachment()->syncWithoutDetaching(
            $request->input('product.gallery', [])
        );
        Alert::info('Продукт добавлен.');
        return redirect()->route('platform.product.list');
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
}
