<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TwoFactorAuthController;

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('two-factor-auth', [TwoFactorAuthController::class, 'index'])->name('2fa.index');
Route::post('two-factor-auth', [TwoFactorAuthController::class, 'store'])->name('2fa.store');
Route::get('two-factor-auth/resent', [TwoFactorAuthController::class, 'resend'])->name('2fa.resend');