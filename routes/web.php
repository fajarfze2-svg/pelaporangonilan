<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;

// Import Controller
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicLaporanController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Teknisi\LaporanController as TeknisiLaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ====================================================
// 1. HALAMAN DEPAN (PUBLIC)
// ====================================================
Route::get('/', function () {
    $laporanTerbaru = Laporan::latest()->take(6)->get();
    $totalLaporan = Laporan::count();
    $laporanSelesai = Laporan::whereIn('status', ['selesai', 'closed'])->count();
    return view('welcome', compact('totalLaporan', 'laporanSelesai', 'laporanTerbaru'));
})->name('welcome');

// Grup untuk Masyarakat (Lapor)
Route::controller(PublicLaporanController::class)->group(function () {
    Route::get('/laporan/cek-status', [PublicLaporanController::class, 'cekStatus'])->name('laporan.cek');
    Route::get('/laporan/sukses/{tiket}', [PublicLaporanController::class, 'sukses'])->name('laporan.sukses');
    Route::get('/laporan/create', 'create')->name('laporan.create');
    Route::post('/laporan', 'store')->name('laporan.store');
    Route::get('/laporan', function () {
        return redirect()->route('laporan.create');
    });
});

// ====================================================
// 2. DASHBOARD UTAMA (Setelah Login)
// ====================================================

// Grup 1: Hanya butuh Login (Untuk halaman ganti password itu sendiri)
Route::middleware(['auth'])->group(function () {
    Route::get('/password/change', [ProfileController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/password/change', [ProfileController::class, 'updatePassword'])->name('password.update');
});

// Grup 2: Butuh Login DAN Wajib Ganti Password (Akses Utama Aplikasi)
Route::middleware(['auth', 'force.password'])->group(function () {

    // Dashboard sekarang aman dan terproteksi
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ====================================================
    // 5. TEKNISI ROUTES
    // ====================================================
    // 'auth' dihapus di sini karena sudah diwariskan dari grup induk di atas
    Route::middleware(['role:teknisi'])
        ->prefix('teknisi')
        ->name('teknisi.')
        ->group(function () {
            Route::get('/laporan/{id}', [TeknisiLaporanController::class, 'show'])->name('laporan.show');
            Route::post('/laporan/upload', [TeknisiLaporanController::class, 'storeBukti'])->name('laporan.upload');
            Route::post('/laporan/start/{id}', [TeknisiLaporanController::class, 'startTask'])->name('laporan.start');
        }); // Penutup grup teknisi

});

// ====================================================
// 4. ADMIN ROUTES (Manual Definition)
// ====================================================
// Semua URL di sini otomatis berawalan: /admin/laporan/...
// Semua Nama Route otomatis berawalan: admin.laporan....
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // 1. INDEX (Daftar Laporan) -> URL: /admin/laporan
        Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');

        // 2. EXPORT PDF -> URL: /admin/laporan/export-pdf
        // (Wajib ditaruh SEBELUM route show/{id} agar tidak dianggap sebagai ID)
        Route::get('/laporan/export-pdf', [AdminLaporanController::class, 'exportPdf'])->name('laporan.export');

        // 3. SHOW (Detail) -> URL: /admin/laporan/{id}
        Route::get('/laporan/{id}', [AdminLaporanController::class, 'show'])->name('laporan.show');

        // 4. UPDATE (Simpan Edit/Status) -> URL: /admin/laporan/{id}
        // Ini adalah rute yang dicari error Anda sebelumnya
        Route::put('/laporan/{id}', [AdminLaporanController::class, 'update'])->name('laporan.update');
        Route::patch('/laporan/{id}', [AdminLaporanController::class, 'update'])->name('laporan.update_patch');

        // 5. DELETE (Hapus) -> URL: /admin/laporan/{id}
        Route::delete('/laporan/{id}', [AdminLaporanController::class, 'destroy'])->name('laporan.destroy');
    });

// ====================================================
// 5. TEKNISI ROUTES
// ====================================================
Route::middleware(['auth', 'role:teknisi'])
    ->prefix('teknisi')
    ->name('teknisi.')
    ->group(function () {
        Route::get('/laporan/{id}', [TeknisiLaporanController::class, 'show'])->name('laporan.show');
        Route::post('/laporan/upload', [TeknisiLaporanController::class, 'storeBukti'])->name('laporan.upload');
        Route::post('/laporan/start/{id}', [TeknisiLaporanController::class, 'startTask'])->name('laporan.start');
    });

require __DIR__ . '/auth.php';
