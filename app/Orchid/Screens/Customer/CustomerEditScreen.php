<?php

namespace App\Orchid\Screens\Customer;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CustomerEditScreen extends Screen
{
    public $customer;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Customer $customer): iterable
    {
        return [
            'customer' => $customer
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование клиента';
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
                ->canSee(!$this->customer->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('save')
                ->canSee($this->customer->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->customer->exists),
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
                    Input::make('customer.name')
                        ->required()
                        ->title('Имя клиента'),
                    Input::make('customer.phone')
                        ->required()
                        ->title('Номер клиента'),
                ])->title('Информация'),
                Layout::rows([

                ])->title('Заказы клиента')
            ])
        ];
    }

    /**
     * @param Customer $customer
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Customer $customer, Request $request): \Illuminate\Http\RedirectResponse
    {
        $customer->fill(
            $request->get('customer')
        )->save();

        Alert::info('Клиент добавлен.');
        return redirect()->route('platform.customer.list');
    }

    /**
     * @param Customer $customer
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Customer $customer): \Illuminate\Http\RedirectResponse
    {
        $customer->delete();
        Alert::info('Клиент удален.');
        return redirect()->route('platform.customer.list');
    }
}
