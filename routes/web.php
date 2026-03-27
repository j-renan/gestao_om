<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('new-order', function () {
    if (!in_array(Auth::user()->role, ['admin', 'collaborator'])) {
        abort(403, 'Acesso restrito ao seu perfil.');
    }
    return Inertia::render('NewOrder');
})->middleware(['auth', 'verified'])->name('new-order');

Route::post('orders', [OrderController::class, 'store'])->middleware(['auth', 'verified'])->name('orders.store');

Route::get('orders', [OrderController::class, 'index'])->middleware(['auth', 'verified'])->name('orders');
Route::patch('orders/{order}', [OrderController::class, 'update'])->middleware(['auth', 'verified'])->name('orders.update');

Route::get('users', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('users');
Route::patch('users/{user}', [UserController::class, 'update'])->middleware(['auth', 'verified'])->name('users.update');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
