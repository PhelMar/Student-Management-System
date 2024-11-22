<?php

use App\Http\Controllers\Guard\ViolationsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_guard'])->prefix('guard')->group(function () {
    Route::get('/violations/create', [ViolationsController::class, 'create'])->name('guard.violations.create');
    Route::post('/violations/store', [ViolationsController::class, 'store'])->name('guard.violations.store');
    Route::get('/get-student', [ViolationsController::class, 'getStudent'])->name('guard.violations.getStudent');
    Route::get('/violations/display', [ViolationsController::class, 'display'])->name('guard.violations.display');
});