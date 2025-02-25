<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionKasirController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth', 'role:SuperAdmin')->group(function(){
    Route::resource('categories', CategoryController::class);
    Route::resource('items', ItemController::class);
    Route::resource('transactions', TransactionController::class);
});

Route::middleware('auth','role:Admin')->group(function(){
    Route::resource('transactions-kasir', TransactionKasirController::class);
});
