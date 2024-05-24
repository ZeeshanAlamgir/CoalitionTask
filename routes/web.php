<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller( ProductController::class )->group( function () {
    Route::get( '/', 'index' );
    Route::post( 'product-store', 'store' )->name('product.store');
} );
