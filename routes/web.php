<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::controller( ProductController::class )->group( function () {
    Route::get( '/', 'index' )->name('products.homepage');
    Route::get( 'get-products', 'getProducts' )->name('products');
    Route::post( 'product-store', 'store' )->name('product.store');
} );
