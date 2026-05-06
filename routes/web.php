<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{BorrowerController, UserController, DashboardController, BooksController, LoginController, DistributorController, PurchaseController};
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// --- GUEST ROUTES ---
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () { return view('welcome'); });
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --- PROTECTED ROUTES ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // IZINKAN: Admin, Guru, dan Kepala Perpustakaan kelola User & Distributor
    Route::middleware(['role:admin,guru,kepala perpustakaan'])->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('distributors', DistributorController::class);
    });

    // IZINKAN: Admin, Guru, dan Kepala Perpustakaan kelola Buku, Borrowers & Purchase
    Route::middleware(['role:admin,guru,kepala perpustakaan'])->group(function () {
        Route::resource('books', BooksController::class);
        Route::resource('borrowers', BorrowerController::class);
        
        // --- PURCHASE ROUTES (MANUAL) ---
        Route::get('purchases', [PurchaseController::class, 'index'])->name('purchases.index');
        Route::get('purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
        Route::post('purchases', [PurchaseController::class, 'store'])->name('purchases.store');
        Route::get('purchases/{no_nota}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');
        Route::put('purchases/{no_nota}', [PurchaseController::class, 'update'])->name('purchases.update');
        Route::delete('purchases/{no_nota}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');
    });

    Route::get('/user/avatar/{id}', [UserController::class, 'showAvatar'])->name('user.avatar');
    Route::post('/user-profile-update', [UserController::class, 'updateProfile'])->name('user.profile.update');
});