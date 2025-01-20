<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Page;


class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        Filament::serving(function () {
            // Ensure we're using the tenant connection
            if (tenant()) {
                config(['database.default' => 'tenant']);
                config(['filament.auth.guard' => 'web']);
                config(['filament.auth.provider' => 'users']);
            }
        });
    }
}
