<?php

use App\Http\Controllers\ProductController;

Route::get('/products/{product}/images', [ProductController::class, 'getImages']);
Route::get('/products/{product}/quick-view', [ProductController::class, 'quickView'])->name('api.products.quick-view');
