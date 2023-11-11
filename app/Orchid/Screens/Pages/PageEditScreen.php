<?php

namespace App\Orchid\Screens\Pages;

use App\Models\FAQ;
use App\Models\Pages;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PageEditScreen extends Screen
{
    public $page;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Pages $page): iterable
    {
        return [
            'page' => $page
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование страницы';
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
                ->canSee(!$this->page->exists),

            Button::make('Обновить')
                ->icon('bs.pencil-square')
                ->method('save')
                ->canSee($this->page->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->page->exists),
        ];
    }

    /**
     * @return iterable
     */
    public function layout(): iterable
    {
        return [
            Layout::columns([
                Layout::rows([
                    Input::make('page.title')
                        ->required()
                        ->title('Название'),
                    Input::make('page.slug')
                        ->required()
                        ->title('Слаг'),
                    Input::make('page.seo_title')
                        ->required()
                        ->title('СЕО тайтл'),
                    Input::make('page.seo_description')
                        ->required()
                        ->title('СЕО описание'),
                    Quill::make('page.body')
                        ->toolbar(["text", "color", "header", "list", "format"])
                        ->required(),
                    Upload::make('page.attachment')
                        ->groups('gallery')
                ])->title('Информация'),
            ])
        ];
    }

    /**
     * @param Pages $page
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Pages $page, Request $request): \Illuminate\Http\RedirectResponse
    {
        $page->fill(
            $request->get('page')
        )->save();
        $page->attachment()->syncWithoutDetaching(
            $request->input('page.attachment', [])
        );
        Alert::info('Страница добавлен.');
        return redirect()->route('platform.page.list');
    }

    /**
     * @param Pages $page
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Pages $page): \Illuminate\Http\RedirectResponse
    {
        $page->delete();
        Alert::info('Страница удалена.');
        return redirect()->route('platform.page.list');
    }
}
