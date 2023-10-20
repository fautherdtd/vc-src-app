<?php

use App\Http\Controllers\Api\Categories;
use App\Http\Controllers\Api\Products;
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

Route::prefix('categories')->group(function () {
    Route::get('list', [Categories::class, 'index'])->name('index');
});

Route::prefix('products')->group(function () {
    Route::get('list', [Products::class, 'index'])->name('index');
    Route::get('popular', [Products::class, 'popular'])->name('popular');
});
