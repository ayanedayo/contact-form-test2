<?php
use App\Http\Controllers\ProductController;

Route::get('/products/register', [ProductController::class, 'create'])->name('products.register');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

Route::get('/products/{product}', [ProductController::class, 'show'])
    ->whereNumber('product')->name('products.show');

Route::post('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');

Route::delete('/products/{product}/delete', [ProductController::class, 'destroy'])
    ->name('products.destroy')->whereNumber('product');
    
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/register', [ProductController::class, 'create'])->name('products.register');