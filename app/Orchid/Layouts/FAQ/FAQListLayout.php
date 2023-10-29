<?php

namespace App\Orchid\Layouts\FAQ;

use App\Models\FAQ;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class FAQListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'faq';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', '#ID'),
            TD::make('title', 'Вопрос')
                ->render(function (FAQ $faq) {
                    return Link::make($faq->title)
                        ->route('platform.faq.edit', $faq);
                }),
            TD::make('content', 'Ответ'),
            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (FAQ $faq) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Редактировать'))
                            ->route('platform.faq.edit', $faq->id)
                            ->icon('bs.pencil'),

                        Button::make(__('Удалить'))
                            ->icon('bs.trash3')
                            ->confirm(__('Удалить.'))
                            ->method('remove', [
                                'id' => $faq->id,
                            ]),
                    ])),
        ];
    }
}
