<?php

namespace App\Orchid\Screens\Order;

use App\Enums\OrderStatuses;
use App\Http\Controllers\Helpers\Images;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Payment;
use App\Services\Order\TimeSlots;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class OrderShowScreen extends Screen
{
    use Images;

    public $order;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Order $order): iterable
    {
        return [
            'order' => $order,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Заказ #' . $this->order->number;
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Информация о заказе.';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function layout(): iterable
    {
        return [
            Layout::legend('order', [
                Sight::make('Номер заказа')->render(fn (Order $order) => $order->number),
                Sight::make('Статус заказа')->render(fn (Order $order) => OrderStatuses::fromName($order->status)),
                Sight::make('Общая сумма заказа')->render(fn (Order $order) => $order->total_price . " руб."),
                Sight::make('Статус оплаты')->render(fn (Order $order) => $order->is_payment ? '<span class="text-success">Оплачен</span>' : '<span class="text-danger">Не оплачен</span>'),
                Sight::make('Заказ поступил')->render(fn (Order $order) => $order->created_at->format('Y-m-d H:i')),
                Sight::make('Комментарий к заказу')->render(fn (Order $order) => $order->notes),
            ]),
            Layout::accordion([
                'Доставка' => Layout::legend('order', [
                    Sight::make('Способ доставки')->render(function (Order $order) {
                        return $order->shipping->label;
                    }),
                    Sight::make('Сумма доставки')->render(function (Order $order) {
                        return $order->shipping_price . " руб.";
                    }),
                    Sight::make('Адрес доставки')->render(fn (Order $order) => $order->address),
                    Sight::make('Дата и время доставки')->render(function (Order $order) {
//                        $slot = new TimeSlots();
//                        $date = Carbon::parse($order->delivery_time)->format('y-m-d');
//                        return "<div> $date ". $slot->slotTimeRange($order->delivery_time) . "</div>";
                        return "<div> ". $order->delivery_time . "</div>";
                    }),
                    Sight::make('Информация')->render(function (Order $order) {
                        return "<div>Подъезд: {$order->address_sub['entrance']}</div>
                            <div>Этаж: {$order->address_sub['floor']}</div>
                            <div>Квартира: {$order->address_sub['apartment']}</div>
                            <div>Домофон: {$order->address_sub['intercom']}</div>";
                    })
                ])
            ]),
            Layout::accordion([
                'Клиент и получатель' => Layout::legend('order', [
                    Sight::make('Клиент')->render(function (Order $order) {
                        $anon = $order->anonymous ?
                            '<span class="text-success">● Да</span>' : '<span class="text-danger">● Нет</span>';
                        return "<div>Имя: {$order->customer->name}</div>
                            <div>Телефон: {$order->customer->phone}</div>
                            <div>Анонимный: $anon</div>";
                    }),
                    Sight::make('Получатель')->render(function (Order $order) {
                        return "<div>Имя: {$order->recipient['name']}</div>
                            <div>Телефон: {$order->recipient['phone']}</div>";
                    }),
                ])
            ]),
            Layout::table('order.items', [
                TD::make('id', '#ID'),
                TD::make('product.image', 'Изображение')->render(function (OrderItems $item) {
                    return "<img height='100px' src='{$this->getUrl($item->{strtolower($item->type)}->attachment->first())}'/>";
                }),
                TD::make('product.name', 'Наименование продукта')->render(function (OrderItems $item) {
                    return $item->{strtolower($item->type)}->name;
                }),
                TD::make('type', 'Тип'),
                TD::make('qty', 'Количество'),
            ])
        ];
    }



}
