<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthControllerApi;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\CategoryController;

// Public routes
Route::post('login', [AuthControllerApi::class, 'login']);

// Authenticated routes
Route::middleware('auth.check')->group(function () {
    // Auth routes
    Route::get('logout', [AuthControllerApi::class, 'logout']);

    // Posts routes with individual permission checks
    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index'])->middleware('auth.check:view_posts');
        Route::post('/', [PostController::class, 'store'])->middleware('auth.check:create_posts');
        Route::get('/{id}', [PostController::class, 'show'])->middleware('auth.check:view_posts');
        Route::put('/{id}', [PostController::class, 'update'])->middleware('auth.check:edit_posts');
        Route::delete('/{id}', [PostController::class, 'destroy'])->middleware('auth.check:delete_posts');
    });

    // Pages routes
    Route::prefix('pages')->group(function () {
        Route::get('/', [PageController::class, 'index'])->middleware('auth.check:view_pages');
        Route::post('/', [PageController::class, 'store'])->middleware('auth.check:create_pages');
        Route::get('/{id}', [PageController::class, 'show'])->middleware('auth.check:view_pages');
        Route::put('/{id}', [PageController::class, 'update'])->middleware('auth.check:edit_pages');
        Route::delete('/{id}', [PageController::class, 'destroy'])->middleware('auth.check:delete_pages');
    });

    // Categories routes
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->middleware('auth.check:view_categories');
        Route::post('/', [CategoryController::class, 'store'])->middleware('auth.check:create_categories');
        Route::get('/{id}', [CategoryController::class, 'show'])->middleware('auth.check:view_categories');
        Route::put('/{id}', [CategoryController::class, 'update'])->middleware('auth.check:edit_categories');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->middleware('auth.check:delete_categories');
    });
});
