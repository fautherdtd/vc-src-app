<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Services\Cart\CartFlowService;
use App\Services\Favorites\FavoritesFlowService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/catalog/{slug?}', [CatalogController::class, 'index'])->name('catalog');
Route::get('/product/{slug}', [ProductController::class, 'index'])->name('product');

Route::get('/delivery', [PageController::class, 'delivery'])->name('delivery');
Route::get('/payment', [PageController::class, 'payment'])->name('payment');
Route::get('/about', [PageController::class, 'about'])->name('about');

Route::prefix('favorites')->name('favorites.')->group(function () {
    Route::get('/', [FavoritesController::class, 'index'])->name('index');
    Route::post('/add', [FavoritesController::class, 'add'])->name('add');
    Route::post('/remove/{id}', [FavoritesFlowService::class, 'remove'])->name('remove');
});

Route::prefix('cart')->name('cart.')->group(function () {
    /** Cart */
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'addToCart'])->name('add');
    Route::put('/update', [CartController::class, 'updateToCart'])->name('update');
    Route::post('/clear', [CartFlowService::class, 'clear'])->name('clear');
    Route::post('/remove/{id}', [CartFlowService::class, 'remove'])->name('remove');

    /** Order */
    Route::get('/order', [CartController::class, 'order'])->name('order');
    Route::post('/order/create', [CartController::class, 'create'])->name('createOrder');

    Route::get('/time/slots', [CartController::class, 'getSlotsTime'])->name('timeSlots');
});
