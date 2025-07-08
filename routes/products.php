<?php

declare(strict_types=1);

use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->middleware([HandlePrecognitiveRequests::class])->name('store');
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::patch('/{product}', [ProductController::class, 'update'])->name('update');
});
