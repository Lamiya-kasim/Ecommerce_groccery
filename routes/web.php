<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Models\Product;
use Illuminate\Http\Request;

Route::get('/products', function () {
    return response()->json(Product::all());
});




Route::view('/orders', 'orders');
Route::view('/about', 'about');
Route::view('/contact', 'contact');
Route::view('/privacy', 'privacy');
Route::view('/cart', 'cart');
Route::view('/order', 'order');




// Show login page
Route::get('/index', function () {
    return view('index');
});


// Show dashboard after login
Route::get('/dashboard', function () {
    return view('dashboard');
});

// Show orders page
Route::get('/orders', function () {
    return view('orders');
});


// Admin login page
Route::get('/admin-login', function () {
    return view('admin_login');
});

// Admin dashboard page (after login)
Route::get('/admin', function () {
    return view('admin');
});

