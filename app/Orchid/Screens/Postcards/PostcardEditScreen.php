<?php

namespace App\Orchid\Screens\Postcards;

use App\Models\Category;
use App\Models\Payment;
use App\Models\Postcards;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PostcardEditScreen extends Screen
{
    public $postcard;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Postcards $postcard): iterable
    {
        return [
            'postcard' => $postcard
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование открытки';
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
                ->canSee(!$this->postcard->exists),

            Button::make('Обновить')
                ->icon('bs.pencil-square')
                ->method('save')
                ->canSee($this->postcard->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->postcard->exists),
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
                    Input::make('postcard.name')
                        ->required()
                        ->title('Наименование'),
                    Input::make('postcard.description')
                        ->required()
                        ->title('Описание'),
                    Input::make('postcard.price')
                        ->required()
                        ->title('Цена'),
                    Select::make('postcard.category_id')
                        ->required()
                        ->placeholder('Выберите категорию')
                        ->title('Категория')
                        ->fromModel(Category::class, 'name'),
                    Upload::make('postcard.attachment')
                        ->groups('postcards')
                ])->title('Информация'),
            ])
        ];
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Postcards $postcard, Request $request): \Illuminate\Http\RedirectResponse
    {
        $postcard->fill(
            $request->get('postcard')
        )->save();
        $postcard->attachment()->syncWithoutDetaching(
            $request->input('postcard.attachment', [])
        );
        Alert::info('Открытка добавлена.');
        return redirect()->route('platform.postcard.list');
    }

    /**
     * @param Postcards $postcard
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Postcards $postcard): \Illuminate\Http\RedirectResponse
    {
        $postcard->delete();
        Alert::info('Открытка удалена.');
        return redirect()->route('platform.postcard.list');
    }
}
