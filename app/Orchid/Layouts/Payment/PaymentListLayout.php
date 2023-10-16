<?php

namespace App\Orchid\Layouts\Payment;

use App\Models\Payment;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PaymentListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'payment';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('label', 'Наименование метода'),
            TD::make('method', 'Тэг метода'),
            TD::make('is_active', 'Активность')
                ->render(fn (Payment $payment) => $payment->is_active ? 'Да' : 'Нет'),
            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Payment $payment) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make(__('Редактировать'))
                            ->route('platform.payment.edit', $payment->id)
                            ->icon('bs.pencil'),

                        Button::make(__('Удалить'))
                            ->icon('bs.trash3')
                            ->confirm(__('Удалить.'))
                            ->method('remove', [
                                'id' => $payment->id,
                            ]),
                    ])),
        ];
    }
}
