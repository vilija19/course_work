<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth','verified')->group(function () {
    Route::prefix('account')->name('account.')->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('wallets', WalletController::class);
        Route::resource('transactions', TransactionController::class);
        Route::post('transactions-internal', [TransactionController::class, 'storeInternal'])->name('transactions.storeinternal');
    });
});