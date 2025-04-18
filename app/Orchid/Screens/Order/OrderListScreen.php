<?php

namespace App\Orchid\Screens\Order;

use App\Models\Order;
use App\Orchid\Layouts\Order\OrderListLayout;
use App\Orchid\Layouts\Order\OrderFiltersLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use App\Orchid\Filters\StatusFilter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;

class OrderListScreen extends Screen
{
/**
 * Fetch data to be displayed on the screen.
 *
 * @return array
 */
    public function query(): iterable
    {
        return [
		'orders' => Order::filters([
                	StatusFilter::class
            	])->defaultSort('id', 'desc')->paginate()
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
        return [
            Button::make('Все')->method('redirectAll'),
            Button::make('Новые')->method('redirectNew'),
            Button::make('Зафиксированные (принятые)')->method('redirectApproved'),
        ];
    }


    public function redirectAll(Request $request) {
        return redirect()->route('platform.order.list');
    }

    public function redirectNew(Request $request) {
        return redirect()->route('platform.order.list',['status'=> 'new']);
    }

    public function redirectApproved(Request $request) {
        return redirect()->route('platform.order.list',['status'=> 'processing']);
    }


    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            OrderListLayout::class
        ];
    }

	   /**
     * @param Request $request
     * @return mixed
     */
    public function activeApproved(Request $request)
    {
        Order::where('id', $request->input('id'))
            ->update(['status' => $request->input('status')]);
        Alert::info('Заказ принят');
        return redirect()->route('platform.order.list');
    }

}
