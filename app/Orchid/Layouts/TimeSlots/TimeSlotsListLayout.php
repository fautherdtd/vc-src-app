<?php

namespace App\Orchid\Layouts\TimeSlots;

use App\Models\Banners;
use App\Models\Category;
use App\Models\TimeSlots;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Alert;

class TimeSlotsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'times';

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
                ->render(function (TimeSlots $slots) {
                    return Link::make($slots->title)
                        ->route('platform.times.edit', $slots);
                }),
            TD::make('is_active', 'Активность')
                ->render(fn (TimeSlots $slots) => $slots->is_active ? 'Да' : 'Нет'),
            TD::make('created_at', 'Создан')
                ->usingComponent(DateTimeSplit::class),
            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (TimeSlots $slots) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make(__('Редактировать'))
                            ->route('platform.times.edit', $slots->id)
                            ->icon('bs.pencil'),
                    ])),
        ];
    }
    /**
     * @param TimeSlots $slots
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(TimeSlots $slots): \Illuminate\Http\RedirectResponse
    {
        $slots->delete();
        Alert::info('Группа удалена.');
        return redirect()->route('platform.times.list');
    }
}
