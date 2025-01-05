<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::get('file/{name}', [FileController::class, 'getFile'])->name('file.index');
