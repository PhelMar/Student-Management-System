<?php

use App\Http\Controllers\User\ClearancesController;
use App\Http\Controllers\User\OrganizationController;
use App\Http\Controllers\User\StudentController;
use App\Http\Controllers\User\ViolationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_user'])->prefix('user')->group(function () {
    Route::get('dashboard', function () {
        return view('users.dashboard');
    })->name('user.dashboard');
    
    Route::get('/create', [StudentController::class, 'create'])->name('user.students.create');
    Route::get('/students/display', [StudentController::class, 'display'])->name('user.students.display');
    Route::get('/students/ipsdisplay', [StudentController::class, 'ipsDisplay'])->name('user.students.ipsdisplay');
    Route::post('/students/store', [StudentController::class, 'store'])->name('user.students.store');
    Route::post('/check-email', [StudentController::class, 'checkEmail'])->name('user.students.checkEmail');
    Route::post('/check-idno', [StudentController::class, 'checkIDNo'])->name('user.students.checkIDNo');
    Route::post('/count-pwd', [StudentController::class, 'countPWDStudents'])->name('user.students.countPWD');
    Route::post('/count-solo-parent', [StudentController::class, 'countSoloParentStudents'])->name('user.students.countSoloParent');
    Route::post('/count-ips', [StudentController::class, 'countIpsStudents'])->name('user.students.countIps');
    Route::post('/count-active-students', [StudentController::class, 'countActiveStudents'])->name('user.students.countActive');
    Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('user.students.edit');
    Route::put('/edit/{id}', [StudentController::class, 'update'])->name('user.students.update');
    Route::get('/StudentView/{id}', [StudentController::class, 'StudentView'])->name('user.students.StudentView');
    Route::get('/students/drop/{id}', [StudentController::class, 'droppedStudent'])->name('user.students.drop');
    Route::get('/students/graduate/{id}', [StudentController::class, 'graduatedStudent'])->name('user.students.graduated');

    Route::get('/get-students/{school_year_id}', [StudentController::class, 'getStudents']);

    Route::get('/violations/create', [ViolationController::class, 'create'])->name('user.violations.create');
    Route::post('/violations/store', [ViolationController::class, 'store'])->name('user.violations.store');
    Route::get('/get-student', [ViolationController::class, 'getStudent'])->name('user.violations.getStudent');
    Route::get('/violations/display', [ViolationController::class, 'display'])->name('user.violations.display');

    Route::get('/organizations/create', [OrganizationController::class, 'create'])->name('user.organizations.create');
    Route::post('/organizations/store', [OrganizationController::class, 'store'])->name('user.organizations.store');
    Route::get('/get-student', [OrganizationController::class, 'getStudent'])->name('user.organizations.getStudent');
    Route::get('/organizations/display', [OrganizationController::class, 'display'])->name('user.organizations.display');

    Route::get('/clearance/create', [ClearancesController::class, 'create'])->name('user.clearance.create');
    Route::post('/clearance/store', [ClearancesController::class, 'store'])->name('user.clearance.store');
    Route::get('/get-student', [ClearancesController::class, 'getStudent'])->name('user.clearance.getStudent');
    Route::get('/clearance/display', [ClearancesController::class, 'display'])->name('user.clearance.display');
    Route::get('/clearance/cleared/{id}', [ClearancesController::class, 'clearedStudent'])->name('user.clearance.cleared');
});