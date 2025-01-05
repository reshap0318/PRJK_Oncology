<?php

use App\Http\Controllers\Auth\{
    AuthenticatedSessionController,
    NewPasswordController,
    PasswordResetLinkController
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

    Route::get('select-data/{type}', [SelectController::class, 'index'])->name('select.data'); //->withoutMiddleware('log');
});
