<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{BorrowerController, UserController, DashboardController, BooksController, LoginController, DistributorController, PurchaseController};

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

    Route::middleware(['role:admin,guru,kepala perpustakaan'])->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('distributors', DistributorController::class);
        Route::resource('books', BooksController::class);
        Route::resource('borrowers', BorrowerController::class);
        
        // --- PURCHASE ROUTES (CLEAN & EXPLICIT) ---
        Route::get('purchases', [PurchaseController::class, 'index'])->name('purchases.index');
        Route::get('purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
        Route::post('purchases', [PurchaseController::class, 'store'])->name('purchases.store');

        // Gunakan grouping prefix untuk parameter {no_nota} agar tidak ambigu
        Route::prefix('purchases')->group(function () {
            Route::get('{no_nota}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit')->where('no_nota', '.*');
            Route::put('{no_nota}', [PurchaseController::class, 'update'])->name('purchases.update')->where('no_nota', '.*');
            Route::delete('{no_nota}', [PurchaseController::class, 'destroy'])->name('purchases.destroy')->where('no_nota', '.*');
        });
    });

    Route::get('/user/avatar/{id}', [UserController::class, 'showAvatar'])->name('user.avatar');
    Route::post('/user-profile-update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/check-boss-password', [UserController::class, 'checkBossPassword'])->name('user.checkBossPassword');
});