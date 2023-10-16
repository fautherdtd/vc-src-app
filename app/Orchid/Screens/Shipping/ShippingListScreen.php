<?php

namespace App\Orchid\Screens\Shipping;

use App\Models\Shipping;
use App\Orchid\Layouts\Shipping\ShippingListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ShippingListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'shipping' => Shipping::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Методы доставки';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить метод доставки')
                ->icon('pencil')
                ->route('platform.shipping.create')
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
            ShippingListLayout::class
        ];
    }
}
