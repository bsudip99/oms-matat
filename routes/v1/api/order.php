<?php

use App\Http\Controllers\Api\V1\Order\OrderController;
use Illuminate\Support\Facades\Route;

/**
 * Entry point for v1 API
 */

/** ORDER ROUTES */

Route::prefix('orders')->group(function () {
  Route::get('', [OrderController::class, 'index'])->name('orders.index');
});
