<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth','verified')->group(function () {
    Route::prefix('account')->name('account.')->group(function () {
        Route::resource('user', UserController::class);
    });
});