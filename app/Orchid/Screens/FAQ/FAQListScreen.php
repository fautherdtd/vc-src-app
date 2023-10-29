<?php

namespace App\Orchid\Screens\FAQ;

use App\Models\FAQ;
use App\Orchid\Layouts\FAQ\FAQListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class FAQListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'faq' => FAQ::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'FAQ список';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить FAQ')
                ->icon('pencil')
                ->route('platform.faq.create')
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
            FAQListLayout::class
        ];
    }
}
