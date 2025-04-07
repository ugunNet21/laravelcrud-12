<?php

use Illuminate\Support\Facades\Route;
use Modules\Book\app\Http\Controllers\BookController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('book', BookController::class)->names('book');
});
