<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\LaporanController;

Route::middleware(['web', 'auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // =====================
        // MANAJEMEN USER
        // =====================
        Route::get('/users', [UserManagementController::class, 'index'])
            ->name('users.index');

        Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])
            ->name('users.edit');

        Route::put('/users/{user}', [UserManagementController::class, 'update'])
            ->name('users.update');

        Route::post('/users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])
            ->name('users.reset-password');

        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])
            ->name('users.destroy');

        Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])
            ->name('admin.laporan.destroy');

        // =====================
        // LAPORAN MASUK
        // =====================
        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index');
        Route::put('/laporan/{laporan}/status', [LaporanController::class, 'updateStatus'])
            ->name('laporan.updateStatus');
    });
