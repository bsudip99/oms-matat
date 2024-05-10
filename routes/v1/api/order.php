<?php

use App\Http\Controllers\Api\V1\Order\OrderController;
use Illuminate\Support\Facades\Route;

/**
 * Entry point for v1 API
 */

/** ORDER ROUTES */
Route::middleware('auth:api')->group(function () {
  Route::prefix('users')->group(function () {
    Route::get('', [OrderController::class, 'index'])->name('orders.index');
  });
});
