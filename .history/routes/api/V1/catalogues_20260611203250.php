<?php

use App\Http\Controllers\Api\V1\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('V1')->group(function () {
    Route::apiResource('categories', CategoryController::class);
});
