<?php

namespace App\Orchid\Screens\Categories;

use App\Models\Category;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class CategoriesEditScreen extends Screen
{
    /**
     * @var Category
     */
    public $category;

    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'Редактирование категории';

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Category $category
     * @return array
     */
    public function query(Category $category): array
    {
        $category->load('attachment');
        return [
            'category' => $category
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->category->exists ?
            'Редактирование категории' : 'Создание новой категории';
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
                ->canSee(!$this->category->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('save')
                ->canSee($this->category->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->category->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::columns([
                Layout::rows([
                    Input::make('category.name')
                        ->required()
                        ->title('Наименование'),

                    CheckBox::make('category.is_visible')
                        ->placeholder('Включить категорию')
                        ->title('Активность'),
                    CheckBox::make('category.is_deactivation')
                        ->sendTrueOrFalse()
                        ->title('Диактивация')
                        ->placeholder('Диактивировать категорию с продуктами'),

                    Input::make('category.position')
                        ->type('number')
                        ->value(1)
                        ->title('Позиция категории в списке'),

                    Upload::make('category.attachment')
                        ->groups('preview')
                        ->maxFiles(1)
                ])->title('Информация'),

                Layout::rows([
                    Input::make('category.seo_title')
                        ->required()
                        ->title('SEO заголовок'),

                    Input::make('category.seo_description')
                        ->required()
                        ->title('SEO описание'),
                ])->title('SEO информация')
            ])
        ];
    }

    /**
     * @param Category $category
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Category $category, Request $request): \Illuminate\Http\RedirectResponse
    {
        $category->fill(
            $request->get('category')
        )->save();
        $category->attachment()->syncWithoutDetaching(
            $request->input('category.attachment', [])
        );
        Alert::info('Категория добавлена.');
        return redirect()->route('platform.category.list');
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
