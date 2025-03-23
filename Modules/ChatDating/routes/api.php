<?php

use Illuminate\Support\Facades\Route;
use Modules\ChatDating\app\Http\Controllers\ChatDatingController;
use Modules\ChatDating\app\Http\Controllers\UserChatController;
use Modules\ChatDating\app\Http\Controllers\FriendshipController;
use Modules\ChatDating\app\Http\Controllers\MessageController;


Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('chatdating', ChatDatingController::class)->names('chatdating');
});

Route::apiResource('user-chat', UserChatController::class);
Route::apiResource('friendships', FriendshipController::class);
Route::apiResource('messages', MessageController::class);