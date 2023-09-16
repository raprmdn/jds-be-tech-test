<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', \App\Http\Controllers\Auth\LoginController::class);
Route::post('/register', \App\Http\Controllers\Auth\RegisterController::class);

Route::middleware('auth:api')->group(function () {

    Route::get('/me', \App\Http\Controllers\Auth\AuthenticatedController::class);
    Route::post('/logout', \App\Http\Controllers\Auth\LogoutController::class);

});
