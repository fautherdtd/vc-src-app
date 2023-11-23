<?php

namespace App\Orchid\Screens\Banners;

use App\Models\Banners;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class BannersEditScreen extends Screen
{
    /**
     * @var Banners
     */
    public $banner;

    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'Редактирование баннера';

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Banners $banner
     * @return array
     */
    public function query(Banners $banner): array
    {
        $banner->load('attachment');
        return [
            'banner' => $banner
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->banner->exists ?
            'Редактирование баннера' : 'Создание нового баннера';
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
                ->canSee(!$this->banner->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('save')
                ->canSee($this->banner->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->banner->exists),
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
                    Input::make('banner.title')
                        ->required()
                        ->title('Наименование'),
                    Input::make('banner.link')
                        ->required()
                        ->title('Ссылка'),
                    Select::make('banner.type')
                        ->options([
                            'modal'   => 'Модальное окно',
                            'banner' => 'Баннер (пока недоступен)',
                        ])
                        ->title('Тип медиа-баннера')
                        ->required(),
                    CheckBox::make('banner.is_active')
                        ->sendTrueOrFalse()
                        ->placeholder('Включить баннер')
                        ->title('Активность'),
                    Upload::make('banner.attachment')
                        ->groups('preview')
                        ->maxFiles(1)
                ])->title('Информация'),
            ])
        ];
    }

    /**
     * @param Banners $banner
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function save(Banners $banner, Request $request): \Illuminate\Http\RedirectResponse
    {
        $banner->fill(
            $request->get('banner')
        )->save();
        $banner->attachment()->syncWithoutDetaching(
            $request->input('banner.attachment', [])
        );
        Alert::info('Баннер добавлен.');
        return redirect()->route('platform.banner.list');
    }

    /**
     * @param Banners $banner
     * @return RedirectResponse
     */
    public function remove(Banners $banner): \Illuminate\Http\RedirectResponse
    {
        $banner->delete();
        Alert::info('Баннер удален.');
        return redirect()->route('platform.banner.list');
    }
}
