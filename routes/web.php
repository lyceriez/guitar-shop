<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\GuitarShopController;

// GUEST ROUTES
// Only accessible to users who are not logged in
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthenticationController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthenticationController::class, 'login'])
        ->name('login.store');

    Route::get('/register', [AuthenticationController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthenticationController::class, 'register'])
        ->name('register.store');

});

// AUTHENTICATED ROUTES
// Only accessible to logged-in users
Route::middleware('auth')->group(function () {

    // Guitar Shop Dashboard
    Route::get('/', [GuitarShopController::class, 'dashboard'])
        ->name('dashboard');

    // Brand
    Route::post('/brand/store', [GuitarShopController::class, 'storeBrand'])
        ->name('brand.store');

    // Guitar
    Route::post('/guitar/store', [GuitarShopController::class, 'storeGuitar'])
        ->name('guitar.store');

    // Specification
    Route::post('/specification/store', [GuitarShopController::class, 'storeSpecification'])
        ->name('specification.store');

    // Customer
    Route::post('/customer/store', [GuitarShopController::class, 'storeCustomer'])
        ->name('customer.store');

    // Purchase
    Route::post('/purchase/store', [GuitarShopController::class, 'storePurchase'])
        ->name('purchase.store');

    // Logout
    Route::post('/logout', [AuthenticationController::class, 'logout'])
        ->name('logout');

});
