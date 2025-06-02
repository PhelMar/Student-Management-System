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
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('admin.register.create');

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
    Route::post('/count-4ps', [StudentController::class, 'countFourPsStudents'])->name('admin.students.countFourps');
    Route::post('/count-scholar-students', [StudentController::class, 'countScholarStudents'])->name('admin.students.countScholar');
    Route::post('/count-active-students', [StudentController::class, 'countActiveStudents'])->name('admin.students.countActive');

    Route::get('/student-counts', [StudentController::class, 'getMunicipalStudentCount'])->name('admin.students.getMunicipalStudentCount');

    Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('admin.students.edit');
    Route::put('/edit/{id}', [StudentController::class, 'update'])->name('admin.students.update');
    Route::get('/StudentView/{id}', [StudentController::class, 'StudentView'])->name('admin.students.StudentView');
    Route::get('/students/drop/{id}', [StudentController::class, 'droppedStudent'])->name('admin.students.drop');
    Route::get('/students/active/{id}', [StudentController::class, 'activeStudent'])->name('admin.students.active');
    Route::get('/students/drop', [StudentController::class, 'dropStudentdisplay'])->name('admin.students.dropView');
    Route::get('/students/graduate/{id}', [StudentController::class, 'graduatedStudent'])->name('admin.students.graduated');
    Route::delete('/students/delete/{id}', [StudentController::class, 'delete'])->name('admin.students.delete');
    //Route::get('/get-students/{school_year_id}', [StudentController::class, 'getStudents']);

    Route::get('/violations/create', [ViolationController::class, 'create'])->name('admin.violations.create');
    Route::post('/violations/store', [ViolationController::class, 'store'])->name('admin.violations.store');
    Route::get('/get-student', [ViolationController::class, 'getStudent'])->name('admin.violations.getStudent');

    Route::get('/violations-data', [ViolationController::class, 'getViolationsData'])->name('admin.violations.chart-data');
    Route::get('/violations/data', [ViolationController::class, 'getBarViolationsData'])->name('admin.violations.bar-data');
    Route::get('/violations/display', [ViolationController::class, 'display'])->name('admin.violations.display');

    Route::get('/total-students/data', [StudentController::class, 'getActiveStudentsStats'])->name('admin.totalStudents.chart-data');

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
    Route::get('/clearance/clearedStudentDisplay', [Clearances::class, 'clearedStudentDisplay'])->name('admin.clearedStudentDisplay.display');

    Route::get('/income-base-report/firstDisplay', [StudentController::class, 'incomeFirstDisplay'])->name('admin.incomeFirstReport.display');
    Route::get('/income-base-report/belowTenK', [StudentController::class, 'belowTenK'])->name('admin.belowTenK.display');
    Route::get('/income-base-report/between10kto20k', [StudentController::class, 'betweenTenAndTwenty'])->name('admin.betweenTenToTwentyThousand.display');
    Route::get('/income-base-report/between20kto30k', [StudentController::class, 'betweenTwentyAndThirty'])->name('admin.betweenTwentyToThirtyThousand.display');
    Route::get('/income-base-report/above30k', [StudentController::class, 'aboveThirty'])->name('admin.aboveThirtyThousand.display');

    Route::get('/students/ipsdisplay', [StudentController::class, 'ipsDisplay'])->name('admin.students.ipsdisplay');
    Route::get('/students/pwddisplay', [StudentController::class, 'pwdDisplay'])->name('admin.students.pwddisplay');
    Route::get('/students/four-ps-display', [StudentController::class, 'fourpsDisplay'])->name('admin.students.fourpsdisplay');
    Route::get('/students/scholar-student-display', [StudentController::class, 'scholarDisplay'])->name('admin.students.scholardisplay');
    Route::get('/students/soloparentdisplay', [StudentController::class, 'soloparentDisplay'])->name('admin.students.soloparentdisplay');

    Route::post('/validate-current-password', [ProfileController::class, 'validateCurrentPassword'])->name('admin.validateCurrentPassword');

    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('/profile/display', [ProfileController::class, 'display'])->name('admin.profile.display');
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
    Route::get('/export-pdf-4ps', [StudentController::class, 'exportFourPsPdf'])->name('admin.export.Fourpspdf');
    Route::get('/export-pdf-Scholar', [StudentController::class, 'exportScholarPdf'])->name('admin.export.Scholarpdf');
    Route::get('/export-pdf-Soloparent', [StudentController::class, 'exportSoloparentPdf'])->name('admin.export.soloparentpdf');

    Route::get('/get-municipalities/{province_id}', [LocationController::class, 'getMunicipalities'])->name('admin.municipalities');
    Route::get('/get-barangays/{municipality_id}', [LocationController::class, 'getBarangays'])->name('admin.barangays');

    Route::get('/students/{id}', [StudentController::class, 'show'])->name('admin.students.show');
    Route::get('/ips/print', [StudentController::class, 'ipsPrint'])->name('admin.ips-student.print');
    Route::get('/pwd/print', [StudentController::class, 'pwdPrint'])->name('admin.pwd-student.print');
    Route::get('/4ps/print', [StudentController::class, 'fourpsPrint'])->name('admin.fourps-student.print');
    Route::get('/Scholar/print', [StudentController::class, 'scholarPrint'])->name('admin.scholar-student.print');
    Route::get('/solo-parent/print', [StudentController::class, 'soloParentPrint'])->name('admin.solo-parent-student.print');
    Route::get('/below-10K/print', [StudentController::class, 'tenKPrint'])->name('admin.below10k.print');
    Route::get('/between10K-20k/print', [StudentController::class, 'tenKandtweentyKPrint'])->name('admin.between10k-20k.print');
    Route::get('/between20K-30k/print', [StudentController::class, 'tweentyKandThirtyKPrint'])->name('admin.between20k-30k.print');
    Route::get('/above30k/print', [StudentController::class, 'aboveThirtyKPrint'])->name('admin.above-30k.print');

    Route::get('/bsit/print', [Clearances::class, 'bsitClearedPrint'])->name('admin.bsit.print');
    Route::get('/bsbafm/print', [Clearances::class, 'bsbafmClearedPrint'])->name('admin.bsbafm.print');
    Route::get('/bsbamm/print', [Clearances::class, 'bsbammClearedPrint'])->name('admin.bsbamm.print');
    Route::get('/bstm/print', [Clearances::class, 'bstmClearedPrint'])->name('admin.bstm.print');
    Route::get('/bsedenglish/print', [Clearances::class, 'bsedenglishClearedPrint'])->name('admin.bsedenglish.print');
    Route::get('/bsedvalues/print', [Clearances::class, 'bsedvaluesClearedPrint'])->name('admin.bsedvalues.print');
    Route::get('/bsedsocialstudies/print', [Clearances::class, 'bsedsocialstudiesClearedPrint'])->name('admin.bsedsocialstudies.print');
    Route::get('/bscrim/print', [Clearances::class, 'bscrimClearedPrint'])->name('admin.bscrim.print');
    Route::get('/beed/print', [Clearances::class, 'beedClearedPrint'])->name('admin.beed.print');

    Route::get('/print-students', [StudentController::class, 'printStudents'])->name('admin.students.print');



    Route::get('/clearance/BSITclearedStudentDisplay', [Clearances::class, 'BSITcleared'])->name('admin.BSITcleared.display');
    Route::get('/clearance/BSTMclearedStudentDisplay', [Clearances::class, 'BSTMcleared'])->name('admin.BSTMcleared.display');
    Route::get('/clearance/BSBA-FMclearedStudentDisplay', [Clearances::class, 'BSBAFMcleared'])->name('admin.BSBAFMcleared.display');
    Route::get('/clearance/BSBA-MMclearedStudentDisplay', [Clearances::class, 'BSBAMMcleared'])->name('admin.BSBAMMcleared.display');
    Route::get('/clearance/BEEDclearedStudentDisplay', [Clearances::class, 'BEEDcleared'])->name('admin.BEEDcleared.display');
    Route::get('/clearance/BSED-SOCIAL-STUDIESclearedStudentDisplay', [Clearances::class, 'BSEDSOCIALSTUDIEScleared'])->name('admin.BSEDSOCIALSTUDIEScleared.display');
    Route::get('/clearance/BSED-ENGLISHclearedStudentDisplay', [Clearances::class, 'BSEDENGLISHcleared'])->name('admin.BSEDENGLISHcleared.display');
    Route::get('/clearance/BSED-VALUESclearedStudentDisplay', [Clearances::class, 'BSEDVALUEScleared'])->name('admin.BSEDVALUEScleared.display');
    Route::get('/clearance/BSCRIMclearedStudentDisplay', [Clearances::class, 'BSCRIMcleared'])->name('admin.BSCRIMcleared.display');

    Route::get('/admin/report', [StudentController::class, 'generateReport'])->name('admin.generateReport');
});