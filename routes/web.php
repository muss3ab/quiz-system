<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tenant/create', [TenantController::class, 'create'])->name('tenant.create');
Route::post('/tenant/store', [TenantController::class, 'store'])->name('tenant.store');
Route::get('/tenant/success', function() {
    return 'Tenant created successfully';
})->name('tenant.success');