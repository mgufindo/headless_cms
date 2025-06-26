<?php

use App\Http\Controllers\Api\AuthControllerApi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\CategoryController;

Route::middleware('api.token')->group(function () {
    // Posts Routes
    Route::apiResource('posts', PostController::class);

    // Pages Routes
    Route::apiResource('pages', PageController::class);

    // Categories Routes
    Route::apiResource('categories', CategoryController::class);
});

Route::post('login', [AuthControllerApi::class, 'login']);
Route::get('logout', [AuthControllerApi::class, 'logout']);
