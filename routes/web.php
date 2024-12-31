<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
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

// Product Routes
Route::get('/', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Cart Routes
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');

// Payment Routes
Route::post('/payment', [PaymentController::class, 'createPayment'])->name('payment.create');
Route::get('/payment/success', function () {
    return view('payment.success'); // Create a success.blade.php view
})->name('payment.success');
Route::get('/payment/pending', function () {
    return view('payment.pending'); // Create a pending.blade.php view
})->name('payment.pending');
Route::get('/payment/error', function () {
    return view('payment.error'); // Create an error.blade.php view
})->name('payment.error');

// Transaction and Promo Routes
Route::get('/transaction/{transactionId}', [PaymentController::class, 'getTransactionDetails']);
Route::post('/promo/{promoId}/search', [PaymentController::class, 'searchPromo']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/verify', [AuthController::class, 'verifyEmail'])->name('verify.email');
