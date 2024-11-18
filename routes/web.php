<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});

// Route untuk Kas (Masuk dan Keluar)
Route::middleware('auth')->group(function () {
    // Menampilkan halaman Kas (Masuk dan Keluar)
    Route::get('/kas', [KasController::class, 'index'])->name('kas.index');
    
    // Menyimpan transaksi Kas Masuk atau Keluar
    Route::post('/kas', [KasController::class, 'store'])->name('kas.store');
    
    // Menampilkan halaman Kas Masuk
    Route::get('/kas/verifikasi', [KasController::class, 'showKasMasuk'])->name('kas.masuk.index');
    
    // Menyimpan transaksi Kas Masuk
    Route::post('/kas/verifikasi', [KasController::class, 'storeKasMasuk'])->name('kas.masuk.store');
    
    // Verifikasi dan Tolak Kas Masuk
    Route::patch('/kas/verifikasi/{id}/verify', [KasController::class, 'verifyKasMasuk'])->name('kas.masuk.verify');
    Route::patch('/kas/verifikasi/{id}/reject', [KasController::class, 'rejectKasMasuk'])->name('kas.masuk.reject');
    
    // Menampilkan halaman Kas Keluar
    Route::get('/kas/keluar', [KasController::class, 'showKasKeluar'])->name('kas.keluar.index');
    
    // Menyimpan transaksi Kas Keluar
    Route::post('/kas/keluar', [KasController::class, 'storeKasKeluar'])->name('kas.keluar.store');

    Route::get('/laporan/kas-masuk', [KasController::class, 'laporanKasMasuk'])->name('laporan.kasMasuk');
    Route::get('/laporan/kas-keluar', [KasController::class, 'laporanKasKeluar'])->name('laporan.kasKeluar');
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
