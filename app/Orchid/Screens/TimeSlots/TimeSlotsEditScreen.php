<?php

namespace App\Orchid\Screens\TimeSlots;

use App\Models\Payment;
use App\Models\Shipping;
use App\Models\TimeSlots;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class TimeSlotsEditScreen extends Screen
{
    public $time;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(TimeSlots $time): iterable
    {
        return [
            'time' => $time
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование группы слотов';
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
                ->canSee(!$this->time->exists),

            Button::make('Обновить')
                ->icon('bs.pencil-square')
                ->method('save')
                ->canSee($this->time->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->time->exists),
        ];
    }

    /**
     * The screen's layout elements.
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::columns([
                Layout::rows([
                    Input::make('time.title')
                        ->required()
                        ->title('Название группы слотов'),
                    CheckBox::make('time.is_active')
                        ->sendTrueOrFalse()
                        ->title('Активность')
                        ->placeholder('Включить слот'),
                ])->title('Информация'),
                Layout::rows([
                    Matrix::make('time.slots')
                        ->columns([
                            'Слот',
                        ]),
                ])->title('Список слотов'),
            ])
        ];
    }

    /**
     * @param TimeSlots $time
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(TimeSlots $time, Request $request): \Illuminate\Http\RedirectResponse
    {
        $time->fill(
            $request->get('time')
        )->save();

        Alert::info('Группа слотов добавлена.');
        return redirect()->route('platform.times.list');
    }

    /**
     * @param TimeSlots $time
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(TimeSlots $time): \Illuminate\Http\RedirectResponse
    {
        $time->delete();
        Alert::info('Группа слотов удалена.');
        return redirect()->route('platform.times.list');
    }
}
