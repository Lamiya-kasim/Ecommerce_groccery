<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\OrderController;
use App\Models\Orders;







/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});




Route::middleware('auth:api')->get('/profile', [AuthController::class, 'profile']);

Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);

//Route::post('/orders/{id}/cancel', [OrderController::class, 'cancelOrder']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

//Route::middleware('auth:api')->post('/orders', [OrderController::class, 'store']);



use App\Http\Controllers\API\ProductController;

Route::get('/products', [ProductController::class, 'index']);



Route::post('/admin/login', [App\Http\Controllers\API\AuthController::class, 'adminLogin']);


Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::post('/admin/products', [ProductController::class, 'store']); // Example admin route
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy']);
});
Route::middleware('auth:api')->delete('/products/{id}', [ProductController::class, 'destroy']);

Route::post('/products', [ProductController::class, 'store']); 
Route::delete('/products/{id}', [ProductController::class, 'destroy']);






