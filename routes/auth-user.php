<?php

use App\Http\Controllers\LocationController;
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
    Route::get('/students/drop', [StudentController::class, 'dropStudentdisplay'])->name('user.students.dropView');
    Route::get('/students/drop/{id}', [StudentController::class, 'droppedStudent'])->name('user.students.drop');
    Route::get('/students/active/{id}', [StudentController::class, 'activeStudent'])->name('user.students.active');
    //Route::get('/get-students/{school_year_id}', [StudentController::class, 'getStudents']);

    Route::get('/violations/create', [ViolationController::class, 'create'])->name('user.violations.create');
    Route::post('/violations/store', [ViolationController::class, 'store'])->name('user.violations.store');
    Route::get('/get-student', [ViolationController::class, 'getStudent'])->name('user.violations.getStudent');

    Route::get('/violations-data', [ViolationController::class, 'getViolationsData'])->name('user.violations.chart-data');
    Route::get('/violations/data', [ViolationController::class, 'getBarViolationsData'])->name('user.violations.bar-data');
    Route::get('/violations/display', [ViolationController::class, 'display'])->name('user.violations.display');

    Route::get('/total-students/data', [StudentController::class, 'getActiveStudentsStats'])->name('user.totalStudents.chart-data');

    Route::get('/organizations/create', [OrganizationController::class, 'create'])->name('user.organizations.create');
    Route::post('/organizations/store', [OrganizationController::class, 'store'])->name('user.organizations.store');
    Route::get('/get-student', [OrganizationController::class, 'getStudent'])->name('user.organizations.getStudent');
    Route::get('/organizations/display', [OrganizationController::class, 'display'])->name('user.organizations.display');
    Route::delete('/organizations/delete/{id}', [OrganizationController::class, 'delete'])->name('user.organizations.delete');

    Route::get('/clearance/create', [ClearancesController::class, 'create'])->name('user.clearance.create');
    Route::post('/clearance/store', [ClearancesController::class, 'store'])->name('user.clearance.store');
    Route::get('/get-student', [ClearancesController::class, 'getStudent'])->name('user.clearance.getStudent');
    Route::get('/clearance/display', [ClearancesController::class, 'display'])->name('user.clearance.display');
    Route::get('/clearance/cleared/{id}', [ClearancesController::class, 'clearedStudent'])->name('user.clearance.cleared');
    Route::get('/clearance/clearedStudentDisplay', [ClearancesController::class, 'clearedStudentDisplay'])->name('user.clearedStudentDisplay.display');

    Route::get('/income-base-report/firstDisplay', [StudentController::class, 'incomeFirstDisplay'])->name('user.incomeFirstReport.display');

    Route::get('/students/ipsdisplay', [StudentController::class, 'ipsDisplay'])->name('user.students.ipsdisplay');
    Route::get('/students/pwddisplay', [StudentController::class, 'pwdDisplay'])->name('user.students.pwddisplay');
    Route::get('/students/soloparentdisplay', [StudentController::class, 'soloparentDisplay'])->name('user.students.soloparentdisplay');

    Route::get('/export-pdf-Ips', [StudentController::class, 'exportIpsPdf'])->name('user.export.IpsPdf');
    Route::get('/export-pdf-Pwd', [StudentController::class, 'exportPwdPdf'])->name('user.export.Pwdpdf');
    Route::get('/export-pdf-Soloparent', [StudentController::class, 'exportSoloparentPdf'])->name('user.export.soloparentpdf');

    Route::get('/provinces', [LocationController::class, 'getProvinces'])->name('user.provinces');
    Route::get('/get-municipalities/{province_id}', [LocationController::class, 'getMunicipalities'])->name('user.municipalities');
    Route::get('/get-barangays/{municipality_id}', [LocationController::class, 'getBarangays'])->name('user.barangays');

    Route::get('/students/{id}', [StudentController::class, 'show'])->name('user.students.show');
    Route::get('/ips/print', [StudentController::class, 'ipsPrint'])->name('user.ips-student.print');
    Route::get('/pwd/print', [StudentController::class, 'pwdPrint'])->name('user.pwd-student.print');
    Route::get('/solo-parent/print', [StudentController::class, 'soloParentPrint'])->name('user.solo-parent-student.print');
    Route::get('/below-10K/print', [StudentController::class, 'tenKPrint'])->name('user.below10k.print');
    Route::get('/between10K-20k/print', [StudentController::class, 'tenKandtweentyKPrint'])->name('user.between10k-20k.print');
    Route::get('/between20K-30k/print', [StudentController::class, 'tweentyKandThirtyKPrint'])->name('user.between20k-30k.print');
    Route::get('/above30k/print', [StudentController::class, 'aboveThirtyKPrint'])->name('user.above-30k.print');

    Route::get('/bsit/print', [ClearancesController::class, 'bsitClearedPrint'])->name('user.bsit.print');
    Route::get('/bsbafm/print', [ClearancesController::class, 'bsbafmClearedPrint'])->name('user.bsbafm.print');
    Route::get('/bsbamm/print', [ClearancesController::class, 'bsbammClearedPrint'])->name('user.bsbamm.print');
    Route::get('/bstm/print', [ClearancesController::class, 'bstmClearedPrint'])->name('user.bstm.print');
    Route::get('/bsedenglish/print', [ClearancesController::class, 'bsedenglishClearedPrint'])->name('user.bsedenglish.print');
    Route::get('/bsedvalues/print', [ClearancesController::class, 'bsedvaluesClearedPrint'])->name('user.bsedvalues.print');
    Route::get('/bsedsocialstudies/print', [ClearancesController::class, 'bsedsocialstudiesClearedPrint'])->name('user.bsedsocialstudies.print');
    Route::get('/bscrim/print', [ClearancesController::class, 'bscrimClearedPrint'])->name('user.bscrim.print');
    Route::get('/beed/print', [ClearancesController::class, 'beedClearedPrint'])->name('user.beed.print');
});