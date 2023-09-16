<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', \App\Http\Controllers\Auth\LoginController::class);
Route::post('/register', \App\Http\Controllers\Auth\RegisterController::class);

Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index']);

Route::middleware('auth:api')->group(function () {

    Route::get('/me', \App\Http\Controllers\Auth\AuthenticatedController::class);
    Route::post('/logout', \App\Http\Controllers\Auth\LogoutController::class);

    Route::post('/news', [\App\Http\Controllers\NewsController::class, 'store'])
        ->middleware('permission:CREATE.NEWS');
    Route::put('/news/{news:slug}', [\App\Http\Controllers\NewsController::class, 'update'])
        ->middleware('permission:EDIT.NEWS');
    Route::delete('/news/{news:slug}', [\App\Http\Controllers\NewsController::class, 'destroy'])
        ->middleware('permission:DELETE.NEWS');

    Route::post('/news/{news:slug}/comments', \App\Http\Controllers\CommentController::class);

});

Route::get('/news/{news:slug}', [\App\Http\Controllers\NewsController::class, 'show']);
