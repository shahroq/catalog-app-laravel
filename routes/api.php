<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => config('app.name')], 200);
});

Route::get('health', function () {
    return response()->json(['ok' => true, 'environment' => config('app.env')], 200);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::get('/products/{id}/tags', [TagController::class, 'index'])->name('product.tags');

    Route::apiResources([
        'products' => ProductController::class,
        'reviews' => ReviewController::class,
        'tags' => TagController::class,
    ]);
});
