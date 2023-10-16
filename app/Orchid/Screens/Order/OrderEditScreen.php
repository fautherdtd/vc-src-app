<?php

namespace App\Orchid\Screens\Order;

use App\Enums\OrderStatuses;
use App\Enums\PaymentStatuses;
use App\Models\Order;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;

class OrderEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Order $order): iterable
    {
        return [
            'order' => $order
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование заказа';
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
            Layout::columns([
                Layout::rows([
                    Input::make('number')
                        ->disabled()
                        ->title('Номер заказа'),
                    Input::make('total_price')
                        ->disabled()
                        ->title('Сумма заказа'),
                    Select::make('status')
                        ->title('Статус')
                        ->options(OrderStatuses::cases())
                ])->title('Заказ'),
                Layout::rows([
                    Input::make('created_at')
                        ->disabled()
                        ->title('Заказ был создан'),
                    Input::make('delivery_time')
                        ->title('Время доставки'),
                    TextArea::make('notes')
                        ->title('Комментарий к заказу'),
                ])->title('Доп. информация')
            ]),
            Layout::columns([
                Layout::rows([
                    Input::make('buyer.name')
                        ->title('Имя заказчика'),
                    Input::make('buyer.phone')
                        ->title('Телефон заказчика')
                ])->title('Заказчик'),
                Layout::rows([
                    Input::make('recipient.name')
                        ->title('Имя получателя'),
                    Input::make('recipient.phone')
                        ->title('Номер получателя'),
                ])->title('Получатель'),
            ]),
            Layout::columns([
                Layout::rows([
                    TextArea::make('address')
                        ->title('Адрес доставки'),
                    Input::make('shipping_price')
                        ->title('Сумма доставки'),
                    Input::make('shipping_method')
                        ->title('Метод доставки'),
                ])->title('Доставка'),
                Layout::rows([
                    Input::make('payment_method')
                        ->title('Метод оплаты'),
                    Select::make('transactions')
                        ->title('Статус заказа')
                        ->options(PaymentStatuses::cases())
                ])->title('Оплата')
            ])
        ];
    }
}
