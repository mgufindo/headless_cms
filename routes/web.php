<?php

use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Role\RoleList;
use App\Livewire\Role\EditPermissions;
use App\Livewire\User\Index as UserIndex;
use App\Livewire\User\Create as UserCreate;
use App\Livewire\User\Edit as UserEdit;

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

// Route::get('/login', LoginForm::class)->name('login');
Route::middleware(['web', 'auth:sanctum'])->group(function () {
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

    Route::get('/', UserIndex::class)->name('users.index');
    Route::get('/create', UserCreate::class)->name('users.create');
    Route::get('/{user}/edit', UserEdit::class)->name('users.edit');
    Route::get('/{user}/editx', UserEdit::class)->name('users.edit-roles');
    Route::get('/role', RoleList::class)->name('roles.index');
    Route::get('/{role}/role', EditPermissions::class)->name('roles.edit');
});
