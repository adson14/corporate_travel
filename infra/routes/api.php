<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::middleware(['cors'])->group(function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::middleware('auth:api')->group(function () {

        Route::controller(NotificationController::class)->group(function () {
            Route::get('/notifications', [NotificationController::class, 'index']);
            Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead']);
        });

        Route::controller(AuthController::class)->group(function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('refresh', [AuthController::class, 'refresh']);
            Route::get('me', [AuthController::class, 'me']);
        });

        Route::controller(OrderController::class)->group(function () {
            Route::get('order', 'list');
            Route::post('order', 'create');
            Route::get('order/{id}', 'show');
            Route::put('order/{orderId}/cancel', 'cancel')->middleware(['permission:cancel-order']);
            Route::put('order/{orderId}/approve', 'approve')->middleware(['permission:approve-order']);
        });
    });
});
