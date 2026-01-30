<?php

use App\Http\Controllers\Web\TestController;
use App\Http\Controllers\Web\TestSecondController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index/{num}', [TestController::class, 'index']);
Route::get('/test/{num}', [TestSecondController::class, 'index']);
