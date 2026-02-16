<?php

use App\Http\Controllers\{
    HomeController,
    DashboardController,
    JadwalController,
    BookingController,
    StatusController,
    ProfileController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
| Routes yang bisa diakses tanpa login (untuk mahasiswa)
|--------------------------------------------------------------------------
*/

// Homepage - Menampilkan daftar dosen
Route::get('/', [HomeController::class, 'index'])->name('home');

// Detail dosen dengan jadwal
Route::get('/dosen/{id}', [HomeController::class, 'show'])->name('dosen.show');

// Submit booking konsultasi (POST dari form publik)
Route::post('/dosen/{id}/booking', [HomeController::class, 'storeBooking'])->name('booking.store.public');

/*
|--------------------------------------------------------------------------
| PUBLIC API ROUTES
| API untuk AJAX calls dari halaman publik
|--------------------------------------------------------------------------
*/

// Get status dosen secara real-time
Route::get('/api/status/{dosenId}', [StatusController::class, 'show'])->name('api.status.show');

// Get jadwal by hari (untuk filter di halaman detail)
Route::get('/api/jadwal/by-day', [JadwalController::class, 'getByDay'])->name('api.jadwal.by-day');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
| Routes yang memerlukan login (untuk dosen)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Get dashboard stats via AJAX
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
    
    /*
    |--------------------------------------------------------------------------
    | PROFILE MANAGEMENT
    | Dari Laravel Breeze (sudah ada)
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    /*
    |--------------------------------------------------------------------------
    | JADWAL MANAGEMENT
    | CRUD untuk jadwal dosen
    |--------------------------------------------------------------------------
    */
    Route::resource('jadwal', JadwalController::class)->except(['show']);
    
    // Alternative manual routes (jika tidak pakai resource):
    // Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    // Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
    // Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    // Route::get('/jadwal/{jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    // Route::put('/jadwal/{jadwal}', [JadwalController::class, 'update'])->name('jadwal.update');
    // Route::delete('/jadwal/{jadwal}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    
    /*
    |--------------------------------------------------------------------------
    | BOOKING MANAGEMENT
    | Approve, reject, dan manage booking dari mahasiswa
    |--------------------------------------------------------------------------
    */
    Route::prefix('booking')->name('booking.')->group(function () {
        // List all bookings with filter
        Route::get('/', [BookingController::class, 'index'])->name('index');
        
        // Show booking detail
        Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
        
        // Approve booking
        Route::post('/{booking}/approve', [BookingController::class, 'approve'])->name('approve');
        
        // Reject booking (dengan alasan)
        Route::post('/{booking}/reject', [BookingController::class, 'reject'])->name('reject');
        
        // Cancel approved booking (back to pending)
        Route::post('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
        
        // Delete booking permanently
        Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('destroy');
    });
    
    /*
    |--------------------------------------------------------------------------
    | STATUS UPDATE
    | Update status dosen real-time
    |--------------------------------------------------------------------------
    */
    // Update status via AJAX dari dashboard
    Route::post('/api/status/update', [StatusController::class, 'update'])->name('status.update');
});

/*
|--------------------------------------------------------------------------
| IOT ROUTES
| Untuk integrasi dengan perangkat IoT (ESP32, dll)
| TIDAK memerlukan auth biasa, tapi pakai token IoT
|--------------------------------------------------------------------------
*/

Route::prefix('iot')->name('iot.')->group(function () {
    // Update status from IoT device
    Route::post('/status/update', [StatusController::class, 'iotUpdate'])->name('status.update');
    
    // Get all lecturers status
    Route::get('/status/all', [StatusController::class, 'getAllStatus'])->name('status.all');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
| Login, Register, Forgot Password, dll (dari Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
