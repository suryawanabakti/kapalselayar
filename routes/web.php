<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\PortController as AdminPortController;
use App\Http\Controllers\User\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookingController::class, 'index']);
Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');

// Dashboard route - redirect based on role
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin' || $user->role === 'super_admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('user.transactions');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [AdminDashboardController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{id}', [AdminDashboardController::class, 'orderDetail'])->name('orders.detail');
    Route::post('/orders/{id}/approve', [AdminDashboardController::class, 'approveOrder'])->name('orders.approve');
    Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');

    // Schedule Management
    Route::resource('schedules', AdminScheduleController::class);

    // Port Management
    Route::resource('ports', AdminPortController::class);
});

// User Routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/bookings/{schedule}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});

Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');
Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');

require __DIR__ . '/auth.php';
