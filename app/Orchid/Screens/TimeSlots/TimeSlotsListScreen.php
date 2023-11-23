<?php

namespace App\Orchid\Screens\TimeSlots;

use App\Models\Shipping;
use App\Models\TimeSlots;
use App\Orchid\Layouts\Shipping\ShippingListLayout;
use App\Orchid\Layouts\TimeSlots\TimeSlotsListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class TimeSlotsListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'times' => TimeSlots::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Слоты доставки';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить группу слотов')
                ->icon('pencil')
                ->route('platform.times.create')
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
            TimeSlotsListLayout::class
        ];
    }
}
