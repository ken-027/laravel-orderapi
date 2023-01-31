<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\Order;
use App\Http\Controllers\Product;

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
Route::post('/register', [Authentication::class, 'register'])->name('register');
Route::post('/login', [Authentication::class, 'login'])->name('login');

// Route::middleware('auth:sanctum')->post('/order', [Order::class, 'create']);
Route::group(['middleware' => 'auth:sanctum'], function () {
  Route::post('/order/{product_id}', [Order::class, 'create'])->whereNumber(['product_id']);
  Route::get('/products', [Product::class, 'list']);
  Route::delete('/logout', [Authentication::class, 'logout']);
});