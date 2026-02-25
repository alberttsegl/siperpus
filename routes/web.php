<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('dashboard', App\Http\Controllers\DashboardController::class);
Route::resource('books', App\Http\Controllers\BooksController::class);
Route::resource('distributors', App\Http\Controllers\DistributorController::class);