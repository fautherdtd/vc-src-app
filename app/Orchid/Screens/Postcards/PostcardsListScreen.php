<?php

namespace App\Orchid\Screens\Postcards;

use App\Models\Postcards;
use App\Orchid\Layouts\Payment\PaymentListLayout;
use App\Orchid\Layouts\Postcards\PostcardListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class PostcardsListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'postcard' => Postcards::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Открытки';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить открытку')
                ->icon('pencil')
                ->route('platform.postcard.create')
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
            PostcardListLayout::class
        ];
    }


    /**
     * @param Payment $category
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Postcards $postcards): \Illuminate\Http\RedirectResponse
    {
        $postcards->delete();
        Alert::info('Открытка удалена.');
        return redirect()->route('platform.postcard.list');
    }
}
