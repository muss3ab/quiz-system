<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/
use App\Models\User;
use Illuminate\Support\Facades\Hash;



Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'tenant_id' => tenant('id'),
        ]);

        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    })->name('tenant.home');

    // Route::get('/quizzes', function () {
    //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    // })->name('tenant.quizzes');

    // Route::get('/users', function () {
    //     return redirect('/admin/users');

    // })->name('tenant.users');

    
});
