<?php

namespace App\Orchid\Screens\Payment;

use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PaymentEditScreen extends Screen
{
    public $payment;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Payment $payment): iterable
    {
        return [
            'payment' => $payment
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование методы оплаты';
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
                ->canSee(!$this->payment->exists),

            Button::make('Обновить')
                ->icon('bs.pencil-square')
                ->method('save')
                ->canSee($this->payment->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->payment->exists),
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
                    Input::make('payment.label')
                        ->required()
                        ->title('Наименование метода'),
                    Input::make('payment.method')
                        ->required()
                        ->title('Тэг метода'),
                    CheckBox::make('payment.is_active')
                        ->title('Активность')
                        ->required()
                        ->value(1)
                        ->placeholder('Активность метода')
                ])->title('Информация'),
            ])
        ];
    }

    /**
     * @param Payment $payment
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Payment $payment, Request $request): \Illuminate\Http\RedirectResponse
    {
        $payment->fill(
            $request->get('payment')
        )->save();

        Alert::info('Метод оплаты добавлен.');
        return redirect()->route('platform.payment.list');
    }

    /**
     * @param Payment $payment
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Payment $payment): \Illuminate\Http\RedirectResponse
    {
        $payment->delete();
        Alert::info('Метод оплаты удален.');
        return redirect()->route('platform.payment.list');
    }
}
