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
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dosen/{id}', [HomeController::class, 'show'])->name('dosen.show');
Route::post('/dosen/{id}/booking', [HomeController::class, 'storeBooking'])->name('booking.store.public');

/*
|--------------------------------------------------------------------------
| PUBLIC API ROUTES (AJAX)
|--------------------------------------------------------------------------
*/
Route::get('/api/status/{dosenId}', [StatusController::class, 'show'])->name('api.status.show');
Route::get('/api/jadwal/by-day', [JadwalController::class, 'getByDay'])->name('api.jadwal.by-day');

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
| IOT ROUTES (token-based)
|--------------------------------------------------------------------------
*/
Route::prefix('iot')->name('iot.')->group(function () {
    Route::post('/status/update', [StatusController::class, 'iotUpdate'])->name('status.update');
    Route::get('/status/all', [StatusController::class, 'getAllStatus'])->name('status.all');
});

/*
|--------------------------------------------------------------------------
| DEBUG ROUTES (hapus setelah beres)
|--------------------------------------------------------------------------
| Ini selaras dengan pola debug di dokumen kamu untuk memecah masalah 500:
| apakah Laravel jalan, apakah DB connect, apakah CA cert ada, dll.
|--------------------------------------------------------------------------
*/
Route::get('/ping', fn () => response()->json(['status' => 'pong']));

Route::get('/debug', function () {
    return response()->json([
        'status' => 'OK',
        'php' => PHP_VERSION,
        'laravel' => app()->version(),
        'env' => app()->environment(),
        'app_key_set' => !empty(config('app.key')),
        'db_default' => config('database.default'),
        'db_host' => config('database.connections.mysql.host'),
        'paths' => [
            'base' => base_path(),
            'storage' => storage_path(),
            'public' => public_path(),
        ],
        'ca_cert' => [
            'path' => storage_path('ca-cert.pem'),
            'exists' => file_exists(storage_path('ca-cert.pem')),
        ],
    ]);
});

Route::get('/db-test', function () {
    try {
        $pdo = \DB::connection()->getPdo();
        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Database connected',
            'users' => \DB::table('users')->count(),
            'jadwals' => \DB::table('jadwals')->count(),
            'bookings' => \DB::table('bookings')->count(),
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'ERROR',
            'message' => $e->getMessage(),
        ], 500);
    }
});

require __DIR__ . '/auth.php';
