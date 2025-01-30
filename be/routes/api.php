<?php

use App\Http\Controllers\Auth\{
    AuthenticatedSessionController,
    NewPasswordController,
    PasswordResetLinkController
};
use App\Http\Controllers\Module\{
    PasienController,
    PasienPemeriksaanController,
    PemeriksaanKemoterapiController,
    PemeriksaanKemoterapiFUController,
    PemeriksaanOperasiController,
    PemeriksaanRadioterapiController,
    PemeriksaanRadioterapiFUController
};
use App\Http\Controllers\SelectController;
use App\Http\Controllers\System\{
    LogUserController,
    ProfileController,
    ScheduleController
};
use App\Http\Controllers\UAM\{
    PermissionController,
    RoleController,
    UserController
};
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest')->name('login');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware('guest')->name('password.reset');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:api')->name('logout');

Route::middleware(['auth:api'])->group(function () {
    Route::post('/log/datatable', [LogUserController::class, 'datatable'])->name('log.datatable');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index']);
        Route::get('/verify-token', [ProfileController::class, 'validedToken']);
        Route::get('/access', [ProfileController::class, 'access']);
        Route::get('/logs', [ProfileController::class, 'logs']);
        Route::patch('/', [ProfileController::class, 'update'])->middleware('log:profile');;
        Route::patch('/change-password', [ProfileController::class, 'changePassword'])->middleware('log:password');
    });

    Route::prefix('system')->group(function () {
        Route::prefix('authorization')->group(function () {
            Route::prefix('permission')->as('permission')->middleware('log:permission')->group(function () {
                Route::get('/{id}', [PermissionController::class, 'getData'])->name('.detail');
                Route::post('/', [PermissionController::class, 'store'])->name('.store');
                Route::post('/datatable', [PermissionController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:permission');
                Route::patch('/{id}', [PermissionController::class, 'update'])->name('.update');
                Route::delete('/{id}', [PermissionController::class, 'destroy'])->name('.delete');
            });

            Route::prefix('role')->as('role')->middleware('log:role')->group(function () {
                Route::get('/{id}', [RoleController::class, 'getData'])->name('.detail');
                Route::post('/', [RoleController::class, 'store'])->name('.store');
                Route::post('/datatable', [RoleController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:role');
                Route::patch('/{id}', [RoleController::class, 'update'])->name('.update');
                Route::delete('/{id}', [RoleController::class, 'destroy'])->name('.delete');
            });
        });

        Route::prefix('user')->as('user')->middleware('log:user')->group(function () {
            Route::get('/{id}', [UserController::class, 'getData'])->name('.detail');
            Route::post('/', [UserController::class, 'store'])->name('.store');
            Route::post('/datatable', [UserController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:user');
            Route::patch('/{id}', [UserController::class, 'update'])->name('.update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('.delete');
        });

        Route::prefix('schedule')->as('schedule.')->middleware('log:schedule')->group(function () {
            Route::get('/', [ScheduleController::class, 'index'])->name('list');
            Route::get('/{id}', [ScheduleController::class, 'show'])->name('data')->withoutMiddleware('log:schedule');

            Route::post('/', [ScheduleController::class, 'store'])->name('store');
            Route::post('/datatable', [ScheduleController::class, 'datatable'])->name('datatable')->withoutMiddleware('log:schedule');
            Route::post('/{id}/result', [ScheduleController::class, 'result'])->name('result')->withoutMiddleware('log:schedule');
            Route::post('/{id}/execute', [ScheduleController::class, 'execute'])->name('execute');

            Route::patch('/{id}', [ScheduleController::class, 'update'])->name('update');
            Route::delete('/{id}', [ScheduleController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('pasien')->as('pasien')->middleware('log:pasien')->group(function () {
        Route::get('/{id}', [PasienController::class, 'getData'])->name('.detail');
        Route::post('/', [PasienController::class, 'store'])->name('.store');
        Route::post('/datatable', [PasienController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pasien');
        Route::post('{id}/datatable-pemeriksaan', [PasienPemeriksaanController::class, 'datatableByPasienId'])
            ->name('.datatableByPasienId')
            ->withoutMiddleware('log:pasien');
        Route::patch('/{id}', [PasienController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PasienController::class, 'destroy'])->name('.delete');
    });

    Route::prefix('pasien-pemeriksaan')->as('pasien-pemeriksaan')->middleware('log:pasien-pemeriksaan')->group(function () {
        Route::get('/{id}', [PasienPemeriksaanController::class, 'getData'])->name('.detail');
        Route::post('/', [PasienPemeriksaanController::class, 'store'])->name('.store');
        Route::post('/datatable', [PasienPemeriksaanController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pasien-pemeriksaan');
        Route::patch('/{id}', [PasienPemeriksaanController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PasienPemeriksaanController::class, 'destroy'])->name('.delete');
    });

    Route::prefix('pemeriksaan-operasi')->as('pemeriksaan-operasi')->middleware('log:pemeriksaan-operasi')->group(function () {
        Route::get('/{id}', [PemeriksaanOperasiController::class, 'getData'])->name('.detail');
        Route::post('/', [PemeriksaanOperasiController::class, 'store'])->name('.store');
        Route::post('/datatable', [PemeriksaanOperasiController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-operasi');
        Route::patch('/{id}', [PemeriksaanOperasiController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PemeriksaanOperasiController::class, 'destroy'])->name('.delete');
    });

    Route::prefix('pemeriksaan-kemoterapi')->as('pemeriksaan-kemoterapi')->middleware('log:pemeriksaan-kemoterapi')->group(function () {
        Route::get('/{id}', [PemeriksaanKemoterapiController::class, 'getData'])->name('.detail');
        Route::post('/', [PemeriksaanKemoterapiController::class, 'store'])->name('.store');
        Route::post('/datatable', [PemeriksaanKemoterapiController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-kemoterapi');
        Route::patch('/{id}', [PemeriksaanKemoterapiController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PemeriksaanKemoterapiController::class, 'destroy'])->name('.delete');
    });

    Route::prefix('pemeriksaan-kemoterapi-fu')->as('pemeriksaan-kemoterapi-fu')->middleware('log:pemeriksaan-kemoterapi-fu')->group(function () {
        Route::get('/{id}', [PemeriksaanKemoterapiFUController::class, 'getData'])->name('.detail');
        Route::post('/', [PemeriksaanKemoterapiFUController::class, 'store'])->name('.store');
        Route::post('/datatable', [PemeriksaanKemoterapiFUController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-kemoterapi-fu');
        Route::patch('/{id}', [PemeriksaanKemoterapiFUController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PemeriksaanKemoterapiFUController::class, 'destroy'])->name('.delete');
    });

    Route::prefix('pemeriksaan-radioterapi')->as('pemeriksaan-radioterapi')->middleware('log:pemeriksaan-radioterapi')->group(function () {
        Route::get('/{id}', [PemeriksaanRadioterapiController::class, 'getData'])->name('.detail');
        Route::post('/', [PemeriksaanRadioterapiController::class, 'store'])->name('.store');
        Route::post('/datatable', [PemeriksaanRadioterapiController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-kemoterapi');
        Route::patch('/{id}', [PemeriksaanRadioterapiController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PemeriksaanRadioterapiController::class, 'destroy'])->name('.delete');
    });

    Route::prefix('pemeriksaan-radioterapi-fu')->as('pemeriksaan-radioterapi-fu')->middleware('log:pemeriksaan-radioterapi-fu')->group(function () {
        Route::get('/{id}', [PemeriksaanRadioterapiFUController::class, 'getData'])->name('.detail');
        Route::post('/', [PemeriksaanRadioterapiFUController::class, 'store'])->name('.store');
        Route::post('/datatable', [PemeriksaanRadioterapiFUController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-radioterapi-fu');
        Route::patch('/{id}', [PemeriksaanRadioterapiFUController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PemeriksaanRadioterapiFUController::class, 'destroy'])->name('.delete');
    });

    Route::get('select-data/{type}', [SelectController::class, 'index'])->name('select.data'); //->withoutMiddleware('log');
});
