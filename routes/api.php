<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [\App\Http\Controllers\Api\ProductController::class, 'index']);

Route::get('/products/{id}', [\App\Http\Controllers\Api\ProductController::class, 'show']);

Route::middleware('auth:api')->group(function() {
    Route::post('/products', [\App\Http\Controllers\Api\ProductController::class, 'store']);

    Route::put('/products/{id}', [\App\Http\Controllers\Api\ProductController::class, 'update']);
    
    Route::delete('/products/{id}', [\App\Http\Controllers\Api\ProductController::class, 'destroy']);
});
