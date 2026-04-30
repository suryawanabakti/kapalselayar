<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\PortController as AdminPortController;
use App\Http\Controllers\Admin\ShipController as AdminShipController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
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

    if ($user->role === 'penjaga') {
        return redirect()->route('admin.scanner');
    }

    return redirect()->route('user.transactions');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin & Penjaga shared routes (Scanner)
Route::middleware(['auth', 'role:admin,super_admin,penjaga'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/scanner', [AdminDashboardController::class, 'scanner'])->name('scanner');
    Route::post('/validate-ticket', [AdminDashboardController::class, 'validateTicket'])->name('validate-ticket');
});

// Admin ONLY Routes
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

    // Ship Management
    Route::resource('ships', AdminShipController::class);

    // User Management
    Route::resource('users', AdminUserController::class);
});

// User Routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
});
Route::get('/ticket/{ticket_code}', [TransactionController::class, 'ticket'])->name('user.transactions.ticket');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/bookings/{schedule}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');
Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');
Route::get('/payment/pay/{order:order_code}', [PaymentController::class, 'pay'])->name('payment.pay');

require __DIR__ . '/auth.php';
