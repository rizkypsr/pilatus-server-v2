<?php

use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\BankController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProvinceController;
use App\Http\Controllers\API\UserController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('user/photo', [UserController::class, 'updatePhoto']);

    Route::get('orders/{status}', [OrderController::class, 'index']);
    Route::get('order/{id}', [OrderController::class, 'show']);
    Route::post('order/status/{id}', [OrderController::class, 'finishOrder']);
    Route::resource('order', OrderController::class, ['except' => ['index', 'show']]);
    Route::resource('cart', CartController::class);
    Route::resource('address', AddressController::class);
    Route::resource('payment', PaymentController::class);
    Route::post('user/update', [UserController::class, 'updateProfile']);
});

Route::resource('bank', BankController::class);
Route::resource('categories', CategoryController::class);
Route::resource('product', ProductController::class);
Route::resource('city', CityController::class);
Route::resource('province', ProvinceController::class);

Route::get('product/category/{category}', [ProductController::class, 'getByCategory']);

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
