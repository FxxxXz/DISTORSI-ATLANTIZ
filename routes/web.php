<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;

// ================= GUEST / PUBLIC ROUTES =================
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/tentang-studio', function () {
    return view('about');
})->name('about');

Route::get('/fasilitas-booking', function () {
    return view('facilities');
})->name('facilities');

Route::get('/kontak', function () {
    return view('contact');
})->name('contact');

// ================= AUTH ROUTES (Login, Register, Forgot Password) =================
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/lupa-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('password.reset');

// ================= LOGOUT =================
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

// ================= PROTECTED ROUTES (Harus Login) =================
Route::middleware('auth')->group(function () {
    // Booking Routes
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    // Dashboard User (dengan pengecekan role)
    Route::get('/dashboard', function () {
        // Jika admin mengakses dashboard user, redirect ke admin dashboard
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');
});

// ================= ADMIN ROUTES (Harus Login & Role Admin) =================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Studio Management
    Route::get('/studios', [App\Http\Controllers\Admin\StudioController::class, 'index'])->name('studios');
    Route::post('/studios', [App\Http\Controllers\Admin\StudioController::class, 'store'])->name('studios.store');
    Route::get('/studios/{id}/edit', [App\Http\Controllers\Admin\StudioController::class, 'edit'])->name('studios.edit');
    Route::put('/studios/{id}', [App\Http\Controllers\Admin\StudioController::class, 'update'])->name('studios.update');
    Route::delete('/studios/{id}', [App\Http\Controllers\Admin\StudioController::class, 'destroy'])->name('studios.destroy');

    // Booking Management
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings');
    Route::get('/bookings/{id}', [App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::put('/bookings/{id}/status', [App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.status');
    Route::delete('/bookings/{id}', [App\Http\Controllers\Admin\BookingController::class, 'destroy'])->name('bookings.destroy');

    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
    Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
});

// ================= REDIRECT KHUSUS (Opsional) =================
// Jika user biasa mengakses /admin, redirect ke dashboard user
Route::get('/admin', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('dashboard');
})->middleware('auth');

// ================= FALLBACK ROUTE (404) =================
Route::fallback(function () {
    return view('errors.404');
});
