<?php

namespace App\Orchid\Screens\Order;


use App\Models\Order;
use App\Orchid\Layouts\Order\OrderListNewLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class OrderListNewScreen extends Screen
{/**
 * Fetch data to be displayed on the screen.
 *
 * @return array
 */
    public function query(): iterable
    {
        return [
            'ordersNew' => Order::where('status', 'new')->orderBy('id', 'DESC')->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Заказы';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            OrderListNewLayout::class,
        ];
    }
}
