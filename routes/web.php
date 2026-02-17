<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    DashboardController,
    JadwalController,
    BookingController,
    StatusController,
    ProfileController
};

/*
|--------------------------------------------------------------------------
| DEBUG ROUTES (hapus setelah production stabil)
|--------------------------------------------------------------------------
*/
Route::get('/ping', fn () => response()->json(['status' => 'pong', 'timestamp' => now()]));

Route::get('/debug', function () {
    return response()->json([
        'status' => 'OK',
        'message' => 'Laravel is running on Vercel',
        'php_version' => PHP_VERSION,
        'laravel_version' => app()->version(),
        'environment' => app()->environment(),
        'env_check' => [
            'APP_KEY_SET' => !empty(config('app.key')),
            'APP_ENV' => config('app.env'),
            'APP_DEBUG' => config('app.debug'),
            'DB_CONNECTION' => config('database.default'),
            'DB_HOST' => config('database.connections.mysql.host'),
        ],
        'paths' => [
            'base_path' => base_path(),
            'storage_path' => storage_path(),
            'public_path' => public_path(),
        ],
        'files_check' => [
            'ca_cert_exists' => file_exists(storage_path('ca-cert.pem')),
            'ca_cert_path' => storage_path('ca-cert.pem'),
        ],
    ]);
});

Route::get('/db-test', function () {
    try {
        \DB::connection()->getPdo();
        
        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Database connected successfully',
            'counts' => [
                'users' => \DB::table('users')->count(),
                'jadwals' => \DB::table('jadwals')->count(),
                'bookings' => \DB::table('bookings')->count(),
            ],
            'database' => config('database.connections.mysql.database'),
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'ERROR',
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
        ], 500);
    }
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dosen/{id}', [HomeController::class, 'show'])->name('dosen.show');
Route::post('/dosen/{id}/booking', [HomeController::class, 'storeBooking'])->name('booking.store.public');

/*
|--------------------------------------------------------------------------
| PUBLIC API ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/api/status/{dosenId}', [StatusController::class, 'show'])->name('api.status.show');
Route::get('/api/jadwal/by-day', [JadwalController::class, 'getByDay'])->name('api.jadwal.by-day');
// Tambahkan di bagian PUBLIC ROUTES (sebelum middleware auth)
Route::post('/dosen/{id}/booking', [HomeController::class, 'storeBooking'])->name('booking.store.public');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('jadwal', JadwalController::class)->except(['show']);

    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
        Route::post('/{booking}/approve', [BookingController::class, 'approve'])->name('approve');
        Route::post('/{booking}/reject', [BookingController::class, 'reject'])->name('reject');
        Route::post('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
        Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('destroy');
    });

    Route::post('/api/status/update', [StatusController::class, 'update'])->name('status.update');
});

/*
|--------------------------------------------------------------------------
| IOT ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('iot')->name('iot.')->group(function () {
    Route::post('/status/update', [StatusController::class, 'iotUpdate'])->name('status.update');
    Route::get('/status/all', [StatusController::class, 'getAllStatus'])->name('status.all');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
