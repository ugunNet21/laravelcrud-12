<?php

use Illuminate\Support\Facades\Route;
use Modules\ChatDating\Http\Controllers\ChatDatingController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('chatdating', ChatDatingController::class)->names('chatdating');
});
