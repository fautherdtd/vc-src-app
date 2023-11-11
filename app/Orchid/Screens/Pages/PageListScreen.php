<?php

namespace App\Orchid\Screens\Pages;

use App\Models\FAQ;
use App\Models\Pages;
use App\Orchid\Layouts\FAQ\FAQListLayout;
use App\Orchid\Layouts\Pages\PageListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class PageListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'page' => Pages::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Страницы';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить страниц')
                ->icon('pencil')
                ->route('platform.page.create')
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
            PageListLayout::class
        ];
    }
}
