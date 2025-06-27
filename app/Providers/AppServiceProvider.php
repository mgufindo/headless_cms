<?php

namespace App\Providers;

use App\Livewire\Auth\LoginForm;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Directive untuk permission
        Blade::if('permission', function ($permission) {
            return auth()->check() && auth()->user()->hasPermission($permission);
        });

        // Directive untuk role
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });
    }
}
