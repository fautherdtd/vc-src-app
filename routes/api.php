<?php

use App\Http\Controllers\Categories;
use App\Http\Controllers\Products;
use App\Http\Controllers\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('yookassa')
    ->post('webhook', [\App\Services\Payment\PaymentHandler::class, 'webhookTransaction']);

Route::post('/telegram/callback', [TelegramController::class, 'handleCallback']);
