<?php

namespace App\Orchid\Screens\Order;

use App\Enums\OrderStatuses;
use App\Enums\PaymentStatuses;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;

class OrderEditScreen extends Screen
{
    public $order;
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
        return [
            Button::make('Обновить')
                ->icon('bs.pencil-square')
                ->method('save')
                ->canSee($this->order->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->order->exists),
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
            Layout::columns([
                Layout::rows([
                    Input::make('order.number')
                        ->disabled()
                        ->title('Номер заказа'),
                    Input::make('order.total_price')
                        ->disabled()
                        ->title('Сумма заказа'),
                    Select::make('order.status')
                        ->title('Статус')
                        ->options([
                            'new' => 'Новый' ,
                            'processing' => 'На оформлении',
                            'shipped' => 'Доставляется',
                            'delivered' => 'Доставлен',
                            'cancelled' => 'Отменен',
                        ])
                ])->title('Заказ'),
                Layout::rows([
                    Input::make('order.created_at')
                        ->disabled()
                        ->title('Заказ был создан'),
                    DateTimer::make('order.delivery_time')
                        ->enableTime()
                        ->title('Время доставки'),
                    TextArea::make('order.notes')
                        ->title('Комментарий к заказу'),
                ])->title('Доп. информация')
            ]),
            Layout::columns([
                Layout::rows([
                    Input::make('order.buyer.name')
                        ->title('Имя заказчика'),
                    Input::make('order.buyer.phone')
                        ->title('Телефон заказчика')
                ])->title('Заказчик'),
                Layout::rows([
                    Input::make('order.recipient.name')
                        ->title('Имя получателя'),
                    Input::make('order.recipient.phone')
                        ->title('Номер получателя'),
                ])->title('Получатель'),
            ]),
            Layout::columns([
                Layout::rows([
                    TextArea::make('order.address')
                        ->title('Адрес доставки'),
                    Input::make('order.shipping_price')
                        ->title('Сумма доставки'),
                    Select::make('order.shipping_method')
                        ->options(Shipping::pluck('label', 'method'))
                        ->title('Метод доставки'),
                ])->title('Доставка'),
                Layout::rows([
                    Select::make('order.payment_method')
                        ->options(Payment::pluck('label', 'method'))
                        ->title('Метод оплаты'),
                    CheckBox::make('order.is_payment')
                        ->title('Статус оплаты')
                        ->placeholder('Заказ оплачен да/нет')
                ])->title('Оплата')
            ])
        ];
    }

    /**
     * @param Order $order
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Order $order, Request $request): \Illuminate\Http\RedirectResponse
    {
        $order->fill(
            $request->get('order')
        )->save();

        Alert::info('Заказ обновлен.');
        return redirect()->route('platform.order.list');
    }

    /**
     * @param Payment $payment
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Order $order): \Illuminate\Http\RedirectResponse
    {
        $order->delete();
        Alert::info('Заказ удален.');
        return redirect()->route('platform.order.list');
    }
}
