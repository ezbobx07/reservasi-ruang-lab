<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\RuangController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

// ----- Guest routes (belum login) -----
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ----- Authenticated routes (Admin & User) -----
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Ruang: semua yang login boleh melihat daftar ruang
    Route::get('/ruang', [RuangController::class, 'index'])->name('ruang.index');

    // Reservasi: user membuat & membatalkan reservasi miliknya
    Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi.index');
    Route::get('/reservasi/create', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
    Route::delete('/reservasi/{reservasi}', [ReservasiController::class, 'destroy'])->name('reservasi.destroy');
});

// ----- Admin-only routes -----
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/ruang/create', [RuangController::class, 'create'])->name('ruang.create');
    Route::post('/ruang', [RuangController::class, 'store'])->name('ruang.store');
    Route::get('/ruang/{ruang}/edit', [RuangController::class, 'edit'])->name('ruang.edit');
    Route::put('/ruang/{ruang}', [RuangController::class, 'update'])->name('ruang.update');
    Route::delete('/ruang/{ruang}', [RuangController::class, 'destroy'])->name('ruang.destroy');

    Route::patch('/reservasi/{reservasi}/status', [ReservasiController::class, 'updateStatus'])->name('reservasi.status');
});
