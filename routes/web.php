<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudioController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KontakController;
use App\Http\Controllers\PaymentController;

// ================= GUEST / PUBLIC ROUTES =================
Route::get('/', fn() => view('home'))->name('home');
Route::get('/tentang-studio', fn() => view('about'))->name('about');
Route::get('/fasilitas-booking', fn() => view('facilities'))->name('facilities');
Route::get('/kontak', fn() => view('contact'))->name('contact');

// ================= AUTH ROUTES (HANYA UNTUK GUEST) =================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout (hanya untuk yang sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ================= PROTECTED ROUTES =================
Route::middleware('auth')->group(function () {
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    // Payment routes
    Route::get('/booking/{booking}/payment', [PaymentController::class, 'form'])->name('payment.form');
    Route::post('/booking/{booking}/payment', [PaymentController::class, 'create'])->name('payment.create');
    Route::get('/payment/{payment}/status', [PaymentController::class, 'status'])->name('payment.status');
    Route::post('/payment/{payment}/proof', [PaymentController::class, 'uploadProof'])->name('payment.proof');
    Route::post('/payment/{payment}/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::post('/payment/{payment}/simulate', [PaymentController::class, 'simulate'])->name('payment.simulate');

    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');
});

// ================= ADMIN ROUTES =================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Payments
    Route::post('payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
    
    // Studios
    Route::get('studios', [StudioController::class, 'index'])->name('studios');
    Route::get('studios/create', [StudioController::class, 'create'])->name('studios.create');
    Route::post('studios', [StudioController::class, 'store'])->name('studios.store');
    Route::get('studios/{studio}/edit', [StudioController::class, 'edit'])->name('studios.edit');
    Route::put('studios/{studio}', [StudioController::class, 'update'])->name('studios.update');
    Route::delete('studios/{studio}', [StudioController::class, 'destroy'])->name('studios.destroy');

    // Bookings
    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings');
    Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::put('bookings/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
    Route::put('bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::put('bookings/{booking}/complete', [AdminBookingController::class, 'complete'])->name('bookings.complete');

    // Users
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Kontaks
    Route::get('kontaks', [KontakController::class, 'index'])->name('kontaks');
    Route::get('kontaks/{id}', [KontakController::class, 'show'])->name('kontaks.show');
    Route::delete('kontaks/{id}', [KontakController::class, 'destroy'])->name('kontaks.destroy');
});

Route::fallback(fn() => view('errors.404'));