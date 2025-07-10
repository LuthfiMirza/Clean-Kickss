<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::put('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
    Route::get('/dashboard/bookings', [DashboardController::class, 'bookings'])->name('dashboard.bookings');
    Route::post('/dashboard/search-bookings', [DashboardController::class, 'searchBookings'])->name('dashboard.search.bookings');
    Route::post('/dashboard/update-phone', [DashboardController::class, 'updatePhoneForBookings'])->name('dashboard.update.phone');
});

// Booking Routes - Specific routes first, then parameterized routes
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::get('/booking/track', [BookingController::class, 'track'])->name('booking.track');
Route::post('/booking/track', [BookingController::class, 'trackResult'])->name('booking.track.result');

// Protected booking routes
Route::middleware('auth')->group(function () {
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/success/{id}', [BookingController::class, 'success'])->name('booking.success');
    Route::post('/booking/{id}/upload-payment-proof', [BookingController::class, 'uploadPaymentProof'])->name('booking.upload.payment.proof');
});

// This route should be last because it has a parameter that could match other routes
Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.show');