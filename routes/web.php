<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DistributorController;

Route::get('/', function () {
    return view('welcome');
});

// Resource routes untuk fitur utama
Route::resource('dashboard', DashboardController::class);
Route::resource('books', BooksController::class);
Route::resource('distributors', DistributorController::class);

// Pakai 'user' (tunggal) agar sesuai dengan folder views/user
Route::resource('user', UserController::class);

// Route tambahan untuk profile & avatar
Route::get('/user/avatar/{id}', [UserController::class, 'showAvatar'])->name('user.avatar');
Route::post('/user-profile-update', [UserController::class, 'updateProfile'])->name('user.profile.update');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
Route::post('/register', [LoginController::class, 'register']);
Route::resource('borrowers', BorrowerController::class);