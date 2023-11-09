<?php

namespace App\Orchid\Layouts\Order;

use Laravel\Prompts\Table;

class OrderItemsTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'order_items';

    protected function columns() : array
    {
        return [
            TD::make('id.','id'),
        ];
    }
}
