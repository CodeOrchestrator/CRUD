<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\FactoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
});



Route::get('/factories', [FactoryController::class, 'index']);
Route::post('/factory', [FactoryController::class, 'create']);
Route::put('/factory/{id}', [FactoryController::class, 'update']);
Route::delete('/factory/{id}', [FactoryController::class, 'delete']);

Route::get('/products', [ProductController::class, 'index']);
Route::post('/product', [ProductController::class, 'create']);
Route::put('/product/{id}', [ProductController::class, 'update']);
Route::delete('/product/{id}', [ProductController::class, 'delete']);

Route::post('register', [AuthController::class, 'register']);
Route::post('verify', [AuthController::class, 'verify']);
Route::post('resend', [AuthController::class, 'resendCode']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forget-password', [AuthController::class, 'forgetPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);


