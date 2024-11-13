<?php

use App\Http\Controllers\Admin\Clearances;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DialectController;
use App\Http\Controllers\Admin\GenderController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ViolationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\OrganizationTypeController;
use App\Http\Controllers\Admin\ParentStatusController;
use App\Http\Controllers\Admin\PositionsController;
use App\Http\Controllers\Admin\ReligionController;
use App\Http\Controllers\Admin\SchoolYearController;
use App\Http\Controllers\Admin\StayController;
use App\Http\Controllers\Admin\ViolationsController;
use App\Http\Controllers\ProfileController;
use App\Models\Course;
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
    //Route::get('/get-students/{school_year_id}', [StudentController::class, 'getStudents']);

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

    Route::get('/gender/display', [GenderController::class, 'display'])->name('admin.gender.display');
    Route::post('/gender/store', [GenderController::class, 'store'])->name('admin.gender.store');
    Route::put('/gender/update/{id}', [GenderController::class, 'update'])->name('admin.gender.update');
    Route::delete('/gender/delete/{id}', [GenderController::class, 'delete'])->name('admin.gender.delete');

    Route::get('/course/display', [CourseController::class, 'display'])->name('admin.course.display');
    Route::post('/course/store', [CourseController::class, 'store'])->name('admin.course.store');
    Route::put('/course/update/{id}', [CourseController::class, 'update'])->name('admin.course.update');
    Route::delete('/course/delete/{id}', [CourseController::class, 'delete'])->name('admin.course.delete');

    Route::get('/income/display', [IncomeController::class, 'display'])->name('admin.income.display');
    Route::post('/income/store', [IncomeController::class, 'store'])->name('admin.income.store');
    Route::put('/income/update/{id}', [IncomeController::class, 'update'])->name('admin.income.update');
    Route::delete('/income/delete/{id}', [IncomeController::class, 'delete'])->name('admin.income.delete');

    Route::get('/organization_type/display', [OrganizationTypeController::class, 'display'])->name('admin.organization_type.display');
    Route::post('/organization_type/store', [OrganizationTypeController::class, 'store'])->name('admin.organization_type.store');
    Route::put('/organization_type/update/{id}', [OrganizationTypeController::class, 'update'])->name('admin.organization_type.update');
    Route::delete('/organization_type/delete/{id}', [OrganizationTypeController::class, 'delete'])->name('admin.organization_type.delete');

    Route::get('/parent_status/display', [ParentStatusController::class, 'display'])->name('admin.parent_status.display');
    Route::post('/parent_status/store', [ParentStatusController::class, 'store'])->name('admin.parent_status.store');
    Route::put('/parent_status/update/{id}', [ParentStatusController::class, 'update'])->name('admin.parent_status.update');
    Route::delete('/parent_status/delete/{id}', [ParentStatusController::class, 'delete'])->name('admin.parent_status.delete');

    Route::get('/position/display', [PositionsController::class, 'display'])->name('admin.position.display');
    Route::post('/position/store', [PositionsController::class, 'store'])->name('admin.position.store');
    Route::put('/position/update/{id}', [PositionsController::class, 'update'])->name('admin.position.update');
    Route::delete('/position/delete/{id}', [PositionsController::class, 'delete'])->name('admin.position.delete');

    Route::get('/religion/display', [ReligionController::class, 'display'])->name('admin.religion.display');
    Route::post('/religion/store', [ReligionController::class, 'store'])->name('admin.religion.store');
    Route::put('/religion/update/{id}', [ReligionController::class, 'update'])->name('admin.religion.update');
    Route::delete('/religion/delete/{id}', [ReligionController::class, 'delete'])->name('admin.religion.delete');

    Route::get('/school_year/display', [SchoolYearController::class, 'display'])->name('admin.school_year.display');
    Route::post('/school_year/store', [SchoolYearController::class, 'store'])->name('admin.school_year.store');
    Route::put('/school_year/update/{id}', [SchoolYearController::class, 'update'])->name('admin.school_year.update');
    Route::delete('/school_year/delete/{id}', [SchoolYearController::class, 'delete'])->name('admin.school_year.delete');

    Route::get('/stay/display', [StayController::class, 'display'])->name('admin.stay.display');
    Route::post('/stay/store', [StayController::class, 'store'])->name('admin.stay.store');
    Route::put('/stay/update/{id}', [StayController::class, 'update'])->name('admin.stay.update');
    Route::delete('/stay/delete/{id}', [StayController::class, 'delete'])->name('admin.stay.delete');

    Route::get('/dialect/display', [DialectController::class, 'display'])->name('admin.dialect.display');
    Route::post('/dialect/store', [DialectController::class, 'store'])->name('admin.dialect.store');
    Route::put('/dialect/update/{id}', [DialectController::class, 'update'])->name('admin.dialect.update');
    Route::delete('/dialect/delete/{id}', [DialectController::class, 'delete'])->name('admin.dialect.delete');

    Route::get('/violation_type/display', [ViolationsController::class, 'display'])->name('admin.violation_type.display');
    Route::post('/violation_type/store', [ViolationsController::class, 'store'])->name('admin.violation_type.store');
    Route::put('/violation_type/update/{id}', [ViolationsController::class, 'update'])->name('admin.violation_type.update');
    Route::delete('/violation_type/delete/{id}', [ViolationsController::class, 'delete'])->name('admin.violation_type.delete');

    Route::get('/export-pdf-Ips', [StudentController::class, 'exportIpsPdf'])->name('admin.export.IpsPdf');
    Route::get('/export-pdf-Pwd', [StudentController::class, 'exportPwdPdf'])->name('admin.export.Pwdpdf');
    Route::get('/export-pdf-Soloparent', [StudentController::class, 'exportSoloparentPdf'])->name('admin.export.soloparentpdf');
});
