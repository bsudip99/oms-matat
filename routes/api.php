<?php

use Illuminate\Support\Facades\Route;

/*
 * VERSION ONE API
 */

Route::prefix('v1')
    ->name('api.v1.')
    ->group(base_path('routes/v1/api/index.php'));
