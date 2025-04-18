<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make('Дашбоард')
                ->icon('bs.pie-chart-fill')
                ->route(config('platform.index')),

            // Магазин
            Menu::make(__('Категории'))
                ->icon('bs.box2')
                ->route('platform.category.list')
                ->title(__('Ресурсы')),
            Menu::make(__('Продукция'))
                ->icon('bs.card-text')
                ->route('platform.product.list'),
            Menu::make(__('Открытки'))
                ->icon('bs.card-text')
                ->route('platform.postcard.list'),
            Menu::make(__('Баннеры'))
                ->icon('bs.image')
                ->route('platform.banner.list'),

            // Заказы
            Menu::make(__('Все'))
                ->icon('bs.box')
                ->route('platform.order.list')
                ->title('Заказы'),

            Menu::make(__('Новые Заказы'))
                ->icon('bs.box')
                ->route('platform.order.list-new'),

            Menu::make(__('Клиенты'))
                ->icon('bs.people')
                ->route('platform.customer.list')
 		->title('Сервисы'),
            Menu::make(__('Методы оплаты'))
                ->icon('bs.credit-card')
                ->route('platform.payment.list'),
            Menu::make(__('Методы доставки'))
                ->icon('bs.truck')
                ->route('platform.shipping.list'),
            Menu::make(__('FAQ'))
                ->icon('bs.question-circle')
                ->route('platform.faq.list'),

            // Система
            Menu::make(__('Страницы'))
                ->icon('bs.file-earmark-fill')
                ->route('platform.page.list')
                ->title(__('Система')),
            Menu::make(__('Временные слоты'))
                ->icon('bs.clock')
                ->route('platform.times.list'),
            Menu::make(__('Транзакции'))
                ->icon('bs.card-list')
                ->route('platform.transactions.list'),

            Menu::make(__('Пользователи'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users'),

            Menu::make(__('Роли'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
