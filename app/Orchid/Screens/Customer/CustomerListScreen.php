<?php

namespace App\Orchid\Screens\Customer;

use App\Models\Customer;
use App\Orchid\Layouts\Customer\CustomerListLayout;
use Orchid\Screen\Screen;

class CustomerListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'customers' => Customer::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Список клиентов';
    }

    /**
     * The screen's action buttons.
     *
     * @return array
     */
    public function commandBar(): array
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
            CustomerListLayout::class
        ];
    }
}
