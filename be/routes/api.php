<?php

use App\Http\Controllers\Auth\{
    AuthenticatedSessionController,
    NewPasswordController,
    PasswordResetLinkController
};
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Module\{
    PasienController,
    PasienPemeriksaanController,
    PemeriksaanBoneSurveyController,
    PemeriksaanKemoterapiController,
    PemeriksaanKemoterapiFUController,
    PemeriksaanLaboratoryController,
    PemeriksaanLainnyaController,
    PemeriksaanMriKepalaController,
    PemeriksaanOperasiController,
    PemeriksaanRadioterapiController,
    PemeriksaanRadioterapiFUController,
    PemeriksaanTerapiTargetController,
    PemeriksaanTerapiTargetFUController,
    PemeriksaanToraksFotoController,
    PemeriksaanToraksScanController,
    PemeriksaanToraksUsgController
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
        Route::post('/datatable', [PemeriksaanRadioterapiController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-radioterapi');
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

    Route::prefix('pemeriksaan-terapi-target')->as('pemeriksaan-terapi-target')->middleware('log:pemeriksaan-terapi-target')->group(function () {
        Route::get('/{id}', [PemeriksaanTerapiTargetController::class, 'getData'])->name('.detail');
        Route::post('/', [PemeriksaanTerapiTargetController::class, 'store'])->name('.store');
        Route::post('/datatable', [PemeriksaanTerapiTargetController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-terapi-target');
        Route::patch('/{id}', [PemeriksaanTerapiTargetController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PemeriksaanTerapiTargetController::class, 'destroy'])->name('.delete');
    });

    Route::prefix('pemeriksaan-terapi-target-fu')->as('pemeriksaan-terapi-target-fu')->middleware('log:pemeriksaan-terapi-target-fu')->group(function () {
        Route::get('/{id}', [PemeriksaanTerapiTargetFUController::class, 'getData'])->name('.detail');
        Route::post('/', [PemeriksaanTerapiTargetFUController::class, 'store'])->name('.store');
        Route::post('/datatable', [PemeriksaanTerapiTargetFUController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-terapi-target-fu');
        Route::patch('/{id}', [PemeriksaanTerapiTargetFUController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PemeriksaanTerapiTargetFUController::class, 'destroy'])->name('.delete');
    });

    Route::prefix('pemeriksaan-lainnya')->as('pemeriksaan-lainnya')->middleware('log:pemeriksaan-lainnya')->group(function () {
        Route::get('/{id}', [PemeriksaanLainnyaController::class, 'getData'])->name('.detail');
        Route::post('/', [PemeriksaanLainnyaController::class, 'store'])->name('.store');
        Route::post('/datatable', [PemeriksaanLainnyaController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-lainnya');
        Route::patch('/{id}', [PemeriksaanLainnyaController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PemeriksaanLainnyaController::class, 'destroy'])->name('.delete');
    });

    // Route::prefix('pemeriksaan-laboratory')->as('pemeriksaan-laboratory')->middleware('log:pemeriksaan-laboratory')->group(function () {
    //     Route::get('/{id}', [PemeriksaanLaboratoryController::class, 'getData'])->name('.detail');
    //     Route::post('/', [PemeriksaanLaboratoryController::class, 'store'])->name('.store');
    //     Route::post('/datatable', [PemeriksaanLaboratoryController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-laboratory');
    //     Route::patch('/{id}', [PemeriksaanLaboratoryController::class, 'update'])->name('.update');
    //     Route::delete('/{id}', [PemeriksaanLaboratoryController::class, 'destroy'])->name('.delete');
    // });

    Route::prefix('pemeriksaan-toraks-usg')->as('pemeriksaan-toraks-usg')->middleware('log:pemeriksaan-toraks-usg')->group(function () {
        Route::get('/{id}', [PemeriksaanToraksUsgController::class, 'getData'])->name('.detail');
        Route::post('/', [PemeriksaanToraksUsgController::class, 'store'])->name('.store');
        Route::post('/datatable', [PemeriksaanToraksUsgController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-toraks-usg');
        Route::patch('/{id}', [PemeriksaanToraksUsgController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PemeriksaanToraksUsgController::class, 'destroy'])->name('.delete');
    });

    Route::prefix('pemeriksaan-toraks-scan')->as('pemeriksaan-toraks-scan')->middleware('log:pemeriksaan-toraks-scan')->group(function () {
        Route::get('/{id}', [PemeriksaanToraksScanController::class, 'getData'])->name('.detail');
        Route::post('/', [PemeriksaanToraksScanController::class, 'store'])->name('.store');
        Route::post('/datatable', [PemeriksaanToraksScanController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-toraks-scan');
        Route::patch('/{id}', [PemeriksaanToraksScanController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PemeriksaanToraksScanController::class, 'destroy'])->name('.delete');
    });

    Route::prefix('pemeriksaan-toraks-foto')->as('pemeriksaan-toraks-foto')->middleware('log:pemeriksaan-toraks-foto')->group(function () {
        Route::get('/{id}', [PemeriksaanToraksFotoController::class, 'getData'])->name('.detail');
        Route::post('/', [PemeriksaanToraksFotoController::class, 'store'])->name('.store');
        Route::post('/datatable', [PemeriksaanToraksFotoController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-toraks-foto');
        Route::patch('/{id}', [PemeriksaanToraksFotoController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PemeriksaanToraksFotoController::class, 'destroy'])->name('.delete');
    });

    Route::prefix('pemeriksaan-bone-survey')->as('pemeriksaan-bone-survey')->middleware('log:pemeriksaan-bone-survey')->group(function () {
        Route::get('/{id}', [PemeriksaanBoneSurveyController::class, 'getData'])->name('.detail');
        Route::post('/', [PemeriksaanBoneSurveyController::class, 'store'])->name('.store');
        Route::post('/datatable', [PemeriksaanBoneSurveyController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-bone-survey');
        Route::patch('/{id}', [PemeriksaanBoneSurveyController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PemeriksaanBoneSurveyController::class, 'destroy'])->name('.delete');
    });

    Route::prefix('pemeriksaan-mri-kepala')->as('pemeriksaan-mri-kepala')->middleware('log:pemeriksaan-mri-kepala')->group(function () {
        Route::get('/{id}', [PemeriksaanMriKepalaController::class, 'getData'])->name('.detail');
        Route::post('/', [PemeriksaanMriKepalaController::class, 'store'])->name('.store');
        Route::post('/datatable', [PemeriksaanMriKepalaController::class, 'datatable'])->name('.datatable')->withoutMiddleware('log:pemeriksaan-mri-kepala');
        Route::patch('/{id}', [PemeriksaanMriKepalaController::class, 'update'])->name('.update');
        Route::delete('/{id}', [PemeriksaanMriKepalaController::class, 'destroy'])->name('.delete');
    });

    Route::prefix('export')->as('export')->group(function () {
        Route::get('/pemeriksaan-pdf/{id}', [ExportController::class, 'pemeriksaanPDF'])->name('.pemeriksaan-pdf');
        Route::get('/pemeriksaan-excel', [ExportController::class, 'pemeriksaanExcel'])->name('.pemeriksaan-excel');
    });
    
    Route::get('select-data/{type}', [SelectController::class, 'index'])->name('select.data'); //->withoutMiddleware('log');
});
