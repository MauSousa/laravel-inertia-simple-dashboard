<?php

declare(strict_types=1);

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->middleware([HandlePrecognitiveRequests::class])
        ->name('store');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});
