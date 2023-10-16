<?php

namespace App\Orchid\Layouts\Order;

use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Layouts\TabMenu;

class OrderTabs extends TabMenu
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = '';

    /**
     * Get the menu elements to be displayed.
     *
     * @return Menu[]
     */
    protected function navigations(): iterable
    {
        return [
            Menu::make('Basic Elements')
                ->route('platform.example.fields'),

            Menu::make('Advanced Elements')
                ->route('platform.example.advanced'),

            Menu::make('Text Editors')
                ->route('platform.example.editors'),

            Menu::make('Run Actions')
                ->route('platform.example.actions'),
        ];
    }
}
