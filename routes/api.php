<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TaskController;

Route::prefix('v1')->group(function(){

    Route::get('/401', function() {
        return response()->json([
            'message' => 'Unautenthicated',
        ], 401);
    })->name('login');

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/verify-email', [AuthController::class, 'verifyEmail']);
    Route::post('/forgot-password',  [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password',  [AuthController::class, 'resetPassword']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/register', [UserController::class, 'register']);
    Route::put('/me', [UserController::class, 'update']);

    Route::apiResource('/todos', TodoController::class);
    Route::apiResource('/todo/{todo}/tasks', TaskController::class);
});


