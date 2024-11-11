<?php

use App\Http\Controllers\Admin\Clearances;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ViolationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('admin.register.create');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('admin.register.store');
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/create', [StudentController::class, 'create'])->name('admin.students.create');
    Route::get('/students/display', [StudentController::class, 'display'])->name('admin.students.display');
    
    Route::post('/students/store', [StudentController::class, 'store'])->name('admin.students.store');
    Route::post('/check-email', [StudentController::class, 'checkEmail'])->name('admin.students.checkEmail');
    Route::post('/check-idno', [StudentController::class, 'checkIDNo'])->name('admin.students.checkIDNo');
    Route::post('/count-pwd', [StudentController::class, 'countPWDStudents'])->name('admin.students.countPWD');
    Route::post('/count-solo-parent', [StudentController::class, 'countSoloParentStudents'])->name('admin.students.countSoloParent');
    Route::post('/count-ips', [StudentController::class, 'countIpsStudents'])->name('admin.students.countIps');
    Route::post('/count-active-students', [StudentController::class, 'countActiveStudents'])->name('admin.students.countActive');
    Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('admin.students.edit');
    Route::put('/edit/{id}', [StudentController::class, 'update'])->name('admin.students.update');
    Route::get('/StudentView/{id}', [StudentController::class, 'StudentView'])->name('admin.students.StudentView');
    Route::get('/students/drop/{id}', [StudentController::class, 'droppedStudent'])->name('admin.students.drop');
    Route::get('/students/graduate/{id}', [StudentController::class, 'graduatedStudent'])->name('admin.students.graduated');
    Route::delete('/students/delete/{id}', [StudentController::class, 'delete'])->name('admin.students.delete');
    Route::get('/get-students/{school_year_id}', [StudentController::class, 'getStudents']);

    Route::get('/violations/create', [ViolationController::class, 'create'])->name('admin.violations.create');
    Route::post('/violations/store', [ViolationController::class, 'store'])->name('admin.violations.store');
    Route::get('/get-student', [ViolationController::class, 'getStudent'])->name('admin.violations.getStudent');
    Route::get('/violations-data', [ViolationController::class, 'getViolationsData'])->name('admin.violations.data');
    Route::get('/violations/data', [ViolationController::class, 'getBarViolationsData'])->name('admin.violations.bar-data');
    Route::get('/violations/display', [ViolationController::class, 'display'])->name('admin.violations.display');

    Route::get('/organizations/create', [OrganizationController::class, 'create'])->name('admin.organizations.create');
    Route::post('/organizations/store', [OrganizationController::class, 'store'])->name('admin.organizations.store');
    Route::get('/get-student', [OrganizationController::class, 'getStudent'])->name('admin.organizations.getStudent');
    Route::get('/organizations/display', [OrganizationController::class, 'display'])->name('admin.organizations.display');
    Route::delete('/organizations/delete/{id}', [OrganizationController::class, 'delete'])->name('admin.organizations.delete');

    Route::get('/clearance/create', [Clearances::class, 'create'])->name('admin.clearance.create');
    Route::post('/clearance/store', [Clearances::class, 'store'])->name('admin.clearance.store');
    Route::get('/get-student', [Clearances::class, 'getStudent'])->name('admin.clearance.getStudent');
    Route::get('/clearance/display', [Clearances::class, 'display'])->name('admin.clearance.display');
    Route::get('/clearance/cleared/{id}', [Clearances::class, 'clearedStudent'])->name('admin.clearance.cleared');

    Route::get('/income-base-report/firstDisplay', [StudentController::class, 'incomeFirstDisplay'])->name('admin.incomeFirstReport.display');

    Route::get('/students/ipsdisplay', [StudentController::class, 'ipsDisplay'])->name('admin.students.ipsdisplay');
    Route::get('/students/pwddisplay', [StudentController::class, 'pwdDisplay'])->name('admin.students.pwddisplay');
    Route::get('/students/soloparentdisplay', [StudentController::class, 'soloparentDisplay'])->name('admin.students.soloparentdisplay');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::get('/profile/display', [ProfileController::class, 'display'])->name('admin.profile.display');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::patch('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('admin.profile.update-password');
    Route::delete('/profile/delete/{id}', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');
});
