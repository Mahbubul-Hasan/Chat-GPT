<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\OpenAIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, "login"]);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('chat', [OpenAIController::class, "chatByOpenAI"]);
        Route::get('chat-histories', [OpenAIController::class, "chatHistories"]);
    });
});
