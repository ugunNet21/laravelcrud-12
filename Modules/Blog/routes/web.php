<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\app\Http\Controllers\BlogController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('blog', BlogController::class)->names('blog');
});
