<?php

use App\Http\Controllers\Api\FactoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/factory', [FactoryController::class, 'index']);
Route::post('/factory', [FactoryController::class, 'create']);
Route::put('/factory/{id}', [FactoryController::class, 'update']);
Route::delete('/factory/{id}', [FactoryController::class, 'delete']);
