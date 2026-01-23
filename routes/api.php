<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\FactoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

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
