<?php

declare(strict_types=1);

use App\Orchid\Screens\Banners\BannersEditScreen;
use App\Orchid\Screens\Banners\BannersListScreen;
use App\Orchid\Screens\Categories\CategoriesEditScreen;
use App\Orchid\Screens\Categories\CategoriesListScreen;
use App\Orchid\Screens\Customer\CustomerEditScreen;
use App\Orchid\Screens\Customer\CustomerListScreen;
use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\FAQ\FAQEditScreen;
use App\Orchid\Screens\FAQ\FAQListScreen;
use App\Orchid\Screens\Order\OrderEditScreen;
use App\Orchid\Screens\Order\OrderListScreen;
use App\Orchid\Screens\Order\OrderShowScreen;
use App\Orchid\Screens\Pages\PageEditScreen;
use App\Orchid\Screens\Pages\PageListScreen;
use App\Orchid\Screens\Payment\PaymentEditScreen;
use App\Orchid\Screens\Payment\PaymentListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Postcards\PostcardEditScreen;
use App\Orchid\Screens\Postcards\PostcardsListScreen;
use App\Orchid\Screens\Products\ProductEditScreen;
use App\Orchid\Screens\Products\ProductListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\Shipping\ShippingEditScreen;
use App\Orchid\Screens\Shipping\ShippingListScreen;
use App\Orchid\Screens\TimeSlots\TimeSlotsEditScreen;
use App\Orchid\Screens\TimeSlots\TimeSlotsListScreen;
use App\Orchid\Screens\Transactions\TransactionsListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

// Categories
Route::prefix('category')->name('platform.category.')->group(function () {
    Route::screen('list', CategoriesListScreen::class)->name('list');
    Route::screen('create', CategoriesEditScreen::class)->name('create');
    Route::screen('edit/{category?}', CategoriesEditScreen::class)->name('edit');
});

// Product
Route::prefix('product')->name('platform.product.')->group(function () {
    Route::screen('list', ProductListScreen::class)->name('list');
    Route::screen('create', ProductEditScreen::class)->name('create');
    Route::screen('edit/{product?}', ProductEditScreen::class)->name('edit');
});

// Customer
Route::prefix('customer')->name('platform.customer.')->group(function () {
    Route::screen('list', CustomerListScreen::class)->name('list');
    Route::screen('create', CustomerEditScreen::class)->name('create');
    Route::screen('edit/{product}', CustomerEditScreen::class)->name('edit');
});

// Customer
Route::prefix('order')->name('platform.order.')->group(function () {
    Route::screen('list', OrderListScreen::class)->name('list');
    Route::screen('show/{order}', OrderShowScreen::class)->name('show');
    Route::screen('edit/{order}', OrderEditScreen::class)->name('edit');
});

// Payment method
Route::prefix('payment')->name('platform.payment.')->group(function () {
    Route::screen('list', PaymentListScreen::class)->name('list');
    Route::screen('create', PaymentEditScreen::class)->name('create');
    Route::screen('edit/{payment?}', PaymentEditScreen::class)->name('edit');
});

// Shipping method
Route::prefix('shipping')->name('platform.shipping.')->group(function () {
    Route::screen('list', ShippingListScreen::class)->name('list');
    Route::screen('create', ShippingEditScreen::class)->name('create');
    Route::screen('edit/{shipping?}', ShippingEditScreen::class)->name('edit');
});

Route::prefix('faq')->name('platform.faq.')->group(function () {
   Route::screen('list', FAQListScreen::class)->name('list');
   Route::screen('create', FAQEditScreen::class)->name('create');
   Route::screen('edit/{faq?}', FAQEditScreen::class)->name('edit');
});

Route::prefix('transactions')->name('platform.transactions.')->group(function () {
   Route::screen('list', TransactionsListScreen::class)->name('list');
});

Route::prefix('page')->name('platform.page.')->group(function () {
   Route::screen('list', PageListScreen::class)->name('list');
   Route::screen('create', PageEditScreen::class)->name('create');
   Route::screen('edit/{page}', PageEditScreen::class)->name('edit');
});

Route::prefix('postcard')->name('platform.postcard.')->group(function () {
   Route::screen('list', PostcardsListScreen::class)->name('list');
   Route::screen('create', PostcardEditScreen::class)->name('create');
   Route::screen('edit/{postcard}', PostcardEditScreen::class)->name('edit');
});

Route::prefix('banner')->name('platform.banner.')->group(function () {
   Route::screen('list', BannersListScreen::class)->name('list');
   Route::screen('create', BannersEditScreen::class)->name('create');
   Route::screen('edit/{banner}', BannersEditScreen::class)->name('edit');
});

Route::prefix('times')->name('platform.times.')->group(function () {
   Route::screen('list', TimeSlotsListScreen::class)->name('list');
   Route::screen('create', TimeSlotsEditScreen::class)->name('create');
   Route::screen('edit/{time}', TimeSlotsEditScreen::class)->name('edit');
});
