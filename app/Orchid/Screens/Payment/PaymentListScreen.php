<?php

namespace App\Orchid\Screens\Payment;

use App\Models\Payment;
use App\Orchid\Layouts\Payment\PaymentListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class PaymentListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'payment' => Payment::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Методы оплаты';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить метод оплаты')
                ->icon('pencil')
                ->route('platform.payment.create')
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
            PaymentListLayout::class
        ];
    }


    /**
     * @param Payment $category
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Payment $payment): \Illuminate\Http\RedirectResponse
    {
        $payment->delete();
        Alert::info('Метод удалена.');
        return redirect()->route('platform.payment.list');
    }
}
