<?php

namespace App\Orchid\Screens\Shipping;

use App\Models\Payment;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ShippingEditScreen extends Screen
{
    public $shipping;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Shipping $shipping): iterable
    {
        return [
            'shipping' => $shipping
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование метода доставки';
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
                ->canSee(!$this->shipping->exists),

            Button::make('Обновить')
                ->icon('bs.pencil-square')
                ->method('save')
                ->canSee($this->shipping->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->shipping->exists),
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
                    Input::make('shipping.label')
                        ->required()
                        ->title('Наименование метода'),
                    Input::make('shipping.method')
                        ->required()
                        ->title('Тэг метода'),
                    CheckBox::make('shipping.is_active')
                        ->title('Активность')
                        ->required()
                        ->value(1)
                        ->placeholder('Активность метода')
                ])->title('Информация'),
            ])
        ];
    }

    /**
     * @param Shipping $shipping
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Shipping $shipping, Request $request): \Illuminate\Http\RedirectResponse
    {
        $shipping->fill(
            $request->get('shipping')
        )->save();

        Alert::info('Метод доставки добавлен.');
        return redirect()->route('platform.shipping.list');
    }

    /**
     * @param Shipping $shipping
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Shipping $shipping): \Illuminate\Http\RedirectResponse
    {
        $shipping->delete();
        Alert::info('Метод оплаты удален.');
        return redirect()->route('platform.shipping.list');
    }
}
