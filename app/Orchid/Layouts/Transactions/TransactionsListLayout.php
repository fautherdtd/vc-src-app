<?php

namespace App\Orchid\Layouts\Transactions;

use App\Models\Transactions;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TransactionsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'transactions';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('uuid', 'Наименование метода'),
            TD::make('amount', 'Сумма транзакции')->render(fn (Transactions $transaction) => $transaction->amount . ' руб.'),
            TD::make('payment_method', 'Метод оплаты'),
            TD::make('order_id', 'Номер заказа'),
        ];
    }
}
