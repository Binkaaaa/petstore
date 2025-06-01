<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\Admin\UserManagement;
use App\Http\Livewire\Admin\ProductManagement;

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
    public function boot()
    {
        // Manually register the admin.user-management component
        Livewire::component('admin.user-management', UserManagement::class);
        // Manually register the admin.product-management component
        Livewire::component('admin.product-management', ProductManagement::class);
    }
}
