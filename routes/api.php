<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

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

Route::prefix('order')->name('order.')->middleware('auth:sanctum')->group(function () {
    Route::post('', [OrderController::class, 'create'])->name('create.post');
    Route::post('{order}/pay', [OrderController::class, 'payOrder'])->name('pay.post');
});

Route::get('products', [ProductController::class, 'index'])->name('product.index.get');
Route::get('transactions', [TransactionController::class, 'index'])->middleware('auth:sanctum')->name('transaction.index.get');


