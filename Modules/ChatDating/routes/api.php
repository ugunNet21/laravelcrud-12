<?php

use Illuminate\Support\Facades\Route;
use Modules\ChatDating\app\Http\Controllers\ChatDatingController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('chatdating', ChatDatingController::class)->names('chatdating');
});
