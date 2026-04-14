<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{BorrowerController, UserController, DashboardController, BooksController, LoginController, DistributorController, PurchaseController};
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// --- GUEST ROUTES (Halaman yang hanya bisa diakses sebelum login) ---
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () { return view('welcome'); });
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);
});

// Logout harus POST demi keamanan CSRF
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --- PROTECTED ROUTES (Halaman setelah login & verifikasi email) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Satu pintu dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Filter akses berdasarkan Role Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('distributors', DistributorController::class);
    });

    // Filter akses berdasarkan Role Admin & Guru
    Route::middleware(['role:admin,guru'])->group(function () {
        Route::resource('books', BooksController::class);
        Route::resource('borrowers', BorrowerController::class);
        Route::resource('purchases', PurchaseController::class);
    });

    // Profile & Avatar (Bisa diakses semua role)
    Route::get('/user/avatar/{id}', [UserController::class, 'showAvatar'])->name('user.avatar');
    Route::post('/user-profile-update', [UserController::class, 'updateProfile'])->name('user.profile.update');
});

// --- EMAIL VERIFICATION ROUTES ---
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// TAMBAHKAN ROUTE INI (Penting untuk tombol Kirim Ulang)
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');