<?php

use Illuminate\Support\Facades\Route;
use Modules\Book\app\Http\Controllers\BookController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('book', BookController::class)->names('book');
});
