<?php

namespace App\Orchid\Layouts\Order;

use App\Enums\OrderStatuses;
use App\Models\Order;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class OrderListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'orders';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     * @throws \ReflectionException
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')
                ->width('100')
                ->render(function (Order $order) {
                    return "<span class='small text-muted mt-1 mb-0'># {$order->id}</span>";
                }),
            TD::make('number', 'Номер заказа')
                ->render(function (Order $order) {
                    return Link::make($order->number)
                        ->route('platform.order.show', $order);
                }),
            TD::make('status', 'Статус заказа')
                ->render(function(Order $order) {
                    return "<span class='small text-muted mt-1 mb-0'>" . OrderStatuses::fromName($order->status) ."</span>";
                }),
            TD::make('total_price', 'Сумма заказа')
                ->render(function(Order $order) {
                    return "<span class='small text-muted mt-1 mb-0'>$order->total_price руб.</span>";
                }),
            TD::make('is_payment', 'Статус оплаты')
                ->render(function(Order $order) {
                    return $order->is_payment ?
                        "<span class='small text-success mt-1 mb-0'>оплачен</span>" :
                        "<span class='small text-danger mt-1 mb-0'>не оплачен</span>";
                }),
            TD::make('created_at', 'Создан')
                ->usingComponent(DateTimeSplit::class),
            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Order $order) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Редактировать'))
                            ->route('platform.order.edit', $order->id)
                            ->icon('bs.pencil'),
                    ])),
        ];
    }
}

