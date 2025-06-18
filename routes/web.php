<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KuaController; 
use App\Http\Controllers\PernikahanController; 
use App\Http\Controllers\LaporanController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetugasKua\RujukController;
use App\Http\Controllers\PerceraianController;
use App\Http\Controllers\AdminUserController; 
use App\Http\Controllers\AdminVerificationController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});


Route::middleware(['auth', 'verified'])->group(function() {

    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // GRUP ROUTE KHUSUS ADMIN
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function() {
        // Verifikasi Pernikahan (Admin)
       Route::resource('users', AdminUserController::class);

        // Dashboard Verifikasi Data (Pernikahan, Rujuk, Perceraian) - Hanya untuk Admin
        Route::get('verification', [AdminVerificationController::class, 'index'])->name('verification.index');

        // === RUTE KHUSUS UNTUK VERIFIKASI PER MODUL (HANYA ADMIN) ===
        // Rute ini dipanggil dari dashboard verifikasi data (admin.verification.index)
        
        // Verifikasi Pernikahan (Admin)
        Route::get('pernikahan/{pernikahan}/verify-form', [AdminVerificationController::class, 'showPernikahanVerificationForm'])->name('pernikahan.show_verify_form');
        Route::patch('pernikahan/{pernikahan}/verify-data', [AdminVerificationController::class, 'verifyPernikahan'])->name('pernikahan.verify_data');

        // Verifikasi Rujuk (Admin)
        Route::get('rujuk/{rujuk}/verify-form', [AdminVerificationController::class, 'showRujukVerificationForm'])->name('rujuk.show_verify_form');
        Route::patch('rujuk/{rujuk}/verify-data', [AdminVerificationController::class, 'verifyRujuk'])->name('rujuk.verify_data');

        // Verifikasi Perceraian (Admin)
        // Note: Method showVerificationForm & verify ada di PerceraianController
        Route::get('perceraians/{perceraian}/verify-form', [PerceraianController::class, 'showVerificationForm'])->name('perceraians.show_verify_form');
        Route::patch('perceraians/{perceraian}/verify-data', [PerceraianController::class, 'verify'])->name('perceraians.verify_data');

    });

    // GRUP ROUTE KHUSUS PETUGAS KUA
    Route::middleware('role:petugas_kua')->prefix('petugas-kua')->name('petugas-kua.')->group(function() {
        
        Route::resource('pernikahan', PernikahanController::class);
        Route::resource('rujuk', RujukController::class);
        Route::resource('perceraians', PerceraianController::class);
        
    });

    // GRUP ROUTE KHUSUS PETUGAS PA
    Route::middleware('role:petugas_pa')->prefix('petugas-pa')->name('petugas-pa.')->group(function() {
       Route::resource('perceraians', PerceraianController::class);
    });

});


require __DIR__.'/auth.php';
