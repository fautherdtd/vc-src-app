<?php

namespace App\Orchid\Screens\FAQ;

use App\Models\FAQ;
use App\Models\Payment;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class FAQEditScreen extends Screen
{
    public $faq;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(FAQ $faq): iterable
    {
        return [
            'faq' => $faq
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование FAQ';
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
                ->canSee(!$this->faq->exists),

            Button::make('Обновить')
                ->icon('bs.pencil-square')
                ->method('save')
                ->canSee($this->faq->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->faq->exists),
        ];
    }

    /**
     * @return iterable
     */
    public function layout(): iterable
    {
        return [
            Layout::columns([
                Layout::rows([
                    Input::make('faq.title')
                        ->required()
                        ->title('Вопрос'),
                    TextArea::make('faq.content')
                        ->required()
                        ->title('Текст ответа'),
                ])->title('Информация'),
            ])
        ];
    }

    /**
     * @param FAQ $faq
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(FAQ $faq, Request $request): \Illuminate\Http\RedirectResponse
    {
        $faq->fill(
            $request->get('faq')
        )->save();

        Alert::info('Метод оплаты добавлен.');
        return redirect()->route('platform.faq.list');
    }

    /**
     * @param FAQ $faq
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(FAQ $faq): \Illuminate\Http\RedirectResponse
    {
        $faq->delete();
        Alert::info('FAQ удален.');
        return redirect()->route('platform.faq.list');
    }
}
