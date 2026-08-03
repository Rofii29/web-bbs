<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Redirect root URL ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route Guest (Belum Authenticated)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Route Authenticated (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route Khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', function () {
            return view('admin.index');
        })->name('admin.index');
    });

    // Route Khusus Karyawan
    Route::middleware('role:karyawan')->group(function () {
        Route::get('/karyawan', function () {
            return view('karyawan.index');
        })->name('karyawan.index');
    });
});
