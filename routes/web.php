<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('new-order', function () {
    return Inertia::render('NewOrder');
})->middleware(['auth', 'verified'])->name('new-order');

Route::post('orders', [OrderController::class, 'store'])->middleware(['auth', 'verified'])->name('orders.store');

Route::get('orders', function () {
    return Inertia::render('Orders');
})->middleware(['auth', 'verified'])->name('orders');

Route::get('users', function () {
    return Inertia::render('Users');
})->middleware(['auth', 'verified'])->name('users');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
