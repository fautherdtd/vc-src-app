<?php

namespace App\Orchid\Screens\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class OrderShowScreen extends Screen
{
    public $oder;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'order' => Order::firstOrFail(),
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
        return [];
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
            Layout::legend('Заказ', [
                Sight::make('number')
                    ->popover('Номер заказа'),
                Sight::make('name'),
                Sight::make('email'),
                Sight::make('email_verified_at', 'Email Verified')->render(fn (User $user) => $user->email_verified_at === null
                    ? '<i class="text-danger">●</i> False'
                    : '<i class="text-success">●</i> True'),
                Sight::make('created_at', 'Created'),
                Sight::make('updated_at', 'Updated'),
                Sight::make('Simple Text')->render(fn () => 'This is a wider card with supporting text below as a natural lead-in to additional content.'),
                Sight::make('Action')->render(fn () => Button::make('Show toast')
                    ->type(Color::BASIC)
                    ->method('showToast')),
            ])->title('User'),
        ];
    }

    public function showToast(Request $request): void
    {
        Toast::warning($request->get('toast', 'Hello, world! This is a toast message.'));
    }
}
