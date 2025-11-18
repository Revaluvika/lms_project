<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// ==================== AUTH ====================
Route::get('/login/{role}', [AuthController::class, 'showLogin'])->name('login.role');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== DASHBOARD ====================
Route::middleware(['auth', 'role:kepala_sekolah'])->group(function () {
    Route::get('/dashboard/kepala-sekolah', function () {
        return view('dashboard.kepala-sekolah');
    })->name('dashboard.kepsek');
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard/guru', function () {
        return view('dashboard.guru');
    })->name('dashboard.guru');
});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard/siswa', function () {
        return view('dashboard.siswa');
    })->name('dashboard.siswa');
});

Route::middleware(['auth', 'role:orang_tua'])->group(function () {
    Route::get('/dashboard/orang-tua', function () {
        return view('dashboard.orang-tua');
    })->name('dashboard.orangtua');
});

Route::middleware(['auth', 'role:dinas'])->group(function () {
    Route::get('/dashboard/dinas', function () {
        return view('dashboard.dinas');
    })->name('dashboard.dinas');
});
