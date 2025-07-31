<?php

declare(strict_types=1);

use App\Http\Controllers\UserPdfController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard', [
        'products' => fn () => Product::count(),
        'users' => fn () => User::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('users-pdf', UserPdfController::class)->name('users-pdf');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/products.php';
require __DIR__ . '/users.php';
