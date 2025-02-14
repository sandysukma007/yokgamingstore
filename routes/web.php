<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Mail;



Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::middleware(['auth:customer'])->group(function () {

    Route::get('/cart/count', [CartController::class, 'cartItemCount']);
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
    Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
    Route::post('/payment', [PaymentController::class, 'createPayment'])->name('payment.create');
    Route::post('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/success', function () {
        return view('payment.success');
    })->name('payment.success.page');

    Route::get('/payment/pending', function () {
        return view('payment.pending');
    })->name('payment.pending');
    Route::get('/payment/error', function () {
        return view('payment.error');
    })->name('payment.error');

    Route::get('/profile', [CustomerController::class, 'profile'])->name('customer.profile');
});


Route::get('/transaction/{transactionId}', [PaymentController::class, 'getTransactionDetails']);
Route::post('/promo/{promoId}/search', [PaymentController::class, 'searchPromo']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/verify', [AuthController::class, 'showVerificationForm'])->name('verify.form');
Route::post('/verify', [AuthController::class, 'verify'])->name('verify');

