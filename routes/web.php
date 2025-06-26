<?php

use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/', Dashboard::class)->name('home');
});

Route::group(['middleware' => ['auth']], function () {
    // Posts
    Route::get('/posts', \App\Livewire\Post\Index::class)->name('posts.index');
    Route::get('/posts/create', \App\Livewire\Post\Create::class)->name('posts.create');
    Route::get('/posts/{post}/edit', \App\Livewire\Post\Edit::class)->name('posts.edit');

    // Categories
    Route::get('/categories', \App\Livewire\Category\Index::class)->name('categories.index');
    Route::get('/categories/create', \App\Livewire\Category\Create::class)->name('categories.create');
    Route::get('/categories/{category}/edit', \App\Livewire\Category\Edit::class)->name('categories.edit');

    // Pages
    Route::get('/pages', \App\Livewire\Page\Index::class)->name('pages.index');
    Route::get('/pages/create', \App\Livewire\Page\Create::class)->name('pages.create');
    Route::get('/pages/{page}/edit', \App\Livewire\Page\Edit::class)->name('pages.edit');
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
