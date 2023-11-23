<?php

namespace App\Orchid\Screens\Banners;

use App\Models\Banners;
use App\Models\Category;
use App\Orchid\Layouts\Banner\BannerListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class BannersListScreen extends Screen
{
    /**
     * Display header name
     *
     * @var string
     */
    public $name = 'Баннеры';

    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'Баннеры';
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'banner' => Banners::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить баннер')
                ->icon('pencil')
                ->route('platform.banner.create')
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
            BannerListLayout::class
        ];
    }


    /**
     * @param Category $category
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Category $category): \Illuminate\Http\RedirectResponse
    {
        $category->delete();
        Alert::info('Баннер удален.');
        return redirect()->route('platform.banner.list');
    }
}
