<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\Auth\RegisterController;

// Public routes
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'store']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'show']);
    Route::post('/logout', [LogoutController::class, 'destroy']);

    Route::get('/quiz/questions', [QuizController::class, 'questions']);
    Route::post('/quiz/submit', [QuizController::class, 'submit']);
    Route::get('/quiz/history', [QuizController::class, 'history']);

    Route::get('/subscription', [SubscriptionController::class, 'show']);
    Route::post('/subscription', [SubscriptionController::class, 'create']);
    Route::delete('/subscription', [SubscriptionController::class, 'cancel']);
    Route::post('/subscription/resume', [SubscriptionController::class, 'resume']);
});
