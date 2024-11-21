<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Baranggay;
use App\Models\Course;
use App\Models\Dialect;
use App\Models\Gender;
use App\Models\HighestEducation;
use App\Models\Income;
use App\Models\Municipality;
use App\Models\ParentStatuses;
use App\Models\Province;
use App\Models\Religion;
use App\Models\SchoolYear;
use App\Models\Semester;
use App\Models\Stay;
use App\Models\Student;
use App\Models\Year;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function create()
    {
        $stays = Stay::all();
        $genders = Gender::all();
        $dialects = Dialect::all();
        $religions = Religion::all();
        $courses = Course::all();
        $years = Year::all();
        $semesters = Semester::all();
        $school_years = SchoolYear::all();
        $highest_educations = HighestEducation::all();
        $incomes = Income::all();
        $parents_status = ParentStatuses::all();
        $provinces = Province::all();

        return view('admin.student-profile.add-student.create', compact(
            'stays',
            'genders',
            'dialects',
            'religions',
            'courses',
            'years',
            'semesters',
            'school_years',
            'highest_educations',
            'incomes',
            'parents_status',
            'provinces'
        ));
    }

    public function countPWDStudents()
    {
        $pwdCount = Student::where('pwd', 'Yes')->count();
        return response()->json(['count' => $pwdCount]);
    }
    public function countSoloParentStudents()
    {

        $soloParentCount = Student::where('solo_parent', 'Yes')->count();
        return response()->json(['count' => $soloParentCount]);
    }
    public function countIpsStudents()
    {

        $ipsCount = Student::where('ips', 'Yes')->count();
        return response()->json(['count' => $ipsCount]);
    }

    public function countActiveStudents()
    {
        $activeCount = Student::where('status', 'active')->count();
        return response()->json(['count' => $activeCount]);
    }


    public function display()
    {

        $students = Student::with(['course', 'year', 'semester', 'school_year'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate();

        return view('admin.student-profile.display', compact(
            'students'
        ));
    }

    public function dropStudentdisplay()
    {

        $students = Student::with(['course', 'year', 'semester', 'school_year'])
            ->where('status', 'dropped')
            ->orderBy('created_at', 'desc')
            ->paginate();

        return view('admin.student-profile.drop-student.display', compact(
            'students'
        ));
    }

    public function show($id)
    {
        $student = Student::with([
            'gender',
            'dialect',
            'StudentsReligion',
            'stay',
            'currentProvince',
            'currentBarangay',
            'currentMunicipality',
            'permanentMunicipality',
            'permanentBarangay',
            'permanentProvince',
            'course',
            'year',
            'semester',
            'school_year',
            'income',
            'parent_status',
            'fathersMunicipality',
            'fathersBarangay',
            'fathersProvince',
            'FathersReligion',
            'FathersHighestEducation',
            'mothersMunicipality',
            'mothersBarangay',
            'mothersProvince',
            'MothersReligion',
            'MothersHighestEducation',
        ])
            ->find($id);

        // Check if the student exists
        if (!$student) {
            return redirect()->route('admin.student-profile.display')->with('error', 'Student not found.');
        }

        // Return the student data to the view
        return view('admin.student-profile.show', compact('student'));
    }

    public function checkEmail(Request $request)
    {
        $email = $request->email;
        $studentId = $request->student_id;

        $emailExists = Student::where('email_address', $email)
            ->where('id_no', '!=', $studentId)
            ->exists();

        return response()->json(['exists' => $emailExists]);
    }
    public function checkIdNo(Request $request)
    {
        $idNo = $request->id_no;
        $studentId = $request->student_id;

        $idExists = Student::where('id_no', $idNo)
            ->where('id', '!=', $studentId)
            ->exists();

        return response()->json(['exists' => $idExists]);
    }


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'id_no' => 'required|digits:10|unique:tbl_students,id_no',
            'first_name' => 'required|max:40',
            'middle_name' => 'nullable|max:40',
            'last_name' => 'required|max:40',
            'nick_name' => 'nullable|max:40',
            'gender_id' => 'required|exists:genders,id',
            'birthdate' => 'required|date',
            'place_of_birth' => 'required',
            'birth_order_among_sibling' => 'required|integer',
            'contact_no' => 'required|digits:11',
            'email_address' => 'required|email|unique:tbl_students,email_address',
            'facebook_account' => 'required|max:50',
            'dialect_id' => 'required|exists:dialects,id',
            'student_religion_id' => 'required|exists:religions,id',
            'stay_id' => 'required|exists:stays,id',
            'fathers_name' => 'nullable|max:90',
            'fathers_birthdate' => 'nullable|date',
            'fathers_place_of_birth' => 'nullable',
            'fathers_contact_no' => 'nullable|digits:11',
            'fathers_highest_education_id' => 'nullable|exists:highest_education,id',
            'fathers_occupation' => 'nullable|max:100',
            'fathers_religion_id' => 'nullable|exists:religions,id',
            'number_of_fathers_sibling' => 'nullable|integer',
            'mothers_name' => 'nullable|max:90',
            'mothers_birthdate' => 'nullable|date',
            'mothers_place_of_birth' => 'nullable',
            'mothers_contact_no' => 'nullable|digits:11',
            'mothers_highest_education_id' => 'nullable|exists:highest_education,id',
            'mothers_occupation' => 'nullable|max:100',
            'mothers_religion_id' => 'nullable|exists:religions,id',
            'number_of_mothers_sibling' => 'nullable|integer',
            'income_id' => 'required|exists:incomes,id',
            'parents_status_id' => 'required|exists:parent_statuses,id',
            'incase_of_emergency_name' => 'required|max:100',
            'incase_of_emergency_contact' => 'required|digits:11',
            'kindergarten' => 'nullable',
            'kindergarten_year_attended' => 'nullable',
            'elementary' => 'required',
            'elementary_year_attended' => 'required|max:12',
            'junior_high' => 'required',
            'junior_high_year_attended' => 'required|max:12',
            'senior_high' => 'nullable',
            'senior_high_year_attended' => 'nullable',
            'pwd' => 'required|in:No,Yes',
            'pwd_remarks' => 'nullable|max:50',
            'ips' => 'required|in:No,Yes',
            'ips_remarks' => 'nullable|max:50',
            'solo_parent' => 'required|in:No,Yes',
            'course_id' => 'required|exists:courses,id',
            'year_id' => 'required|exists:years,id',
            'semester_id' => 'required|exists:semesters,id',
            'school_year_id' => 'required|exists:school_years,id',
            'current_province_id' => 'required|exists:provinces,prov_code',
            'current_municipality_id' => 'required|exists:municipalities,citymun_code',
            'current_barangay_id' => 'required|exists:baranggays,brgy_code',
            'current_purok' => 'nullable|string|max:100',
            'permanent_province_id' => 'required|exists:provinces,prov_code',
            'permanent_municipality_id' => 'required|exists:municipalities,citymun_code',
            'permanent_barangay_id' => 'required|exists:baranggays,brgy_code',
            'permanent_purok' => 'nullable|string|max:100',
            'fathers_province_id' => 'nullable|exists:provinces,prov_code',
            'fathers_municipality_id' => 'nullable|exists:municipalities,citymun_code',
            'fathers_barangay_id' => 'nullable|exists:baranggays,brgy_code',
            'fathers_purok' => 'nullable|string|max:100',
            'mothers_province_id' => 'nullable|exists:provinces,prov_code',
            'mothers_municipality_id' => 'nullable|exists:municipalities,citymun_code',
            'mothers_barangay_id' => 'nullable|exists:baranggays,brgy_code',
            'mothers_purok' => 'nullable|string|max:100',
        ]);

        $validatedData['age'] = Carbon::parse($validatedData['birthdate'])->age;
        $student = Student::create($validatedData);

        if ($student) {
            session()->flash('success', 'Added Successfully');
            return redirect()->route('admin.students.create');
        } else {
            session()->flash('error', 'Error occured');
            return redirect()->route('admin.students.create');
        }
    }
    public function edit($id)
    {
        $students = Student::with([
            'StudentsReligion',
            'FathersReligion',
            'MothersReligion',
            'FathersHighestEducation',
            'MothersHighestEducation',
        ])->findOrFail($id);

        $stays = Stay::all();
        $genders = Gender::all();
        $dialects = Dialect::all();
        $religions = Religion::all();
        $courses = Course::all();
        $years = Year::all();
        $semesters = Semester::all();
        $school_years = SchoolYear::all();
        $highest_educations = HighestEducation::all();
        $incomes = Income::all();
        $parents_status = ParentStatuses::all();
        $provinces = Province::all();
        $municipalities = Municipality::where('prov_code', $students->current_province_id)->get();
        $barangays = Baranggay::where('citymun_code', $students->current_municipality_id)->get();

        return view('admin.student-profile..edit-student.edit', compact(
            'stays',
            'genders',
            'dialects',
            'religions',
            'courses',
            'years',
            'semesters',
            'school_years',
            'highest_educations',
            'incomes',
            'parents_status',
            'students',
            'provinces',
            'municipalities',
            'barangays'
        ));
    }

    public function StudentView($id)
    {
        $students = Student::with([
            'StudentsReligion',
            'FathersReligion',
            'MothersReligion',
            'FathersHighestEducation',
            'MothersHighestEducation'
        ])->findOrFail($id);

        $stays = Stay::all();
        $genders = Gender::all();
        $dialects = Dialect::all();
        $religions = Religion::all();
        $courses = Course::all();
        $years = Year::all();
        $semesters = Semester::all();
        $school_years = SchoolYear::all();
        $highest_educations = HighestEducation::all();
        $incomes = Income::all();
        $parents_status = ParentStatuses::all();
        $provinces = Province::all();
        $municipalities = Municipality::where('prov_code', $students->current_province_id)->get();
        $barangays = Baranggay::where('citymun_code', $students->current_municipality_id)->get();

        return view('admin.student-profile.view', compact(
            'stays',
            'genders',
            'dialects',
            'religions',
            'courses',
            'years',
            'semesters',
            'school_years',
            'highest_educations',
            'incomes',
            'parents_status',
            'students',
            'provinces',
            'municipalities',
            'barangays'
        ));
    }
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'id_no' => 'required|digits:10|unique:tbl_students,id_no,' . $id,
            'first_name' => 'required|max:40',
            'middle_name' => 'nullable|max:40',
            'last_name' => 'required|max:40',
            'nick_name' => 'nullable|max:40',
            'gender_id' => 'required|exists:genders,id',
            'birthdate' => 'required|date',
            'place_of_birth' => 'required',
            'birth_order_among_sibling' => 'required|integer',
            'contact_no' => 'required|digits:11',
            'email_address' => 'required|email|unique:tbl_students,email_address,' . $id,
            'facebook_account' => 'required|max:50',
            'dialect_id' => 'required|exists:dialects,id',
            'student_religion_id' => 'required|exists:religions,id',
            'stay_id' => 'required|exists:stays,id',
            'fathers_name' => 'nullable|max:90',
            'fathers_birthdate' => 'nullable|date',
            'fathers_place_of_birth' => 'nullable',
            'fathers_contact_no' => 'nullable|digits:11',
            'fathers_highest_education_id' => 'nullable|exists:highest_education,id',
            'fathers_occupation' => 'nullable|max:100',
            'fathers_religion_id' => 'nullable|exists:religions,id',
            'number_of_fathers_sibling' => 'nullable|integer',
            'mothers_name' => 'nullable|max:90',
            'mothers_birthdate' => 'nullable|date',
            'mothers_place_of_birth' => 'nullable',
            'mothers_contact_no' => 'nullable|digits:11',
            'mothers_highest_education_id' => 'nullable|exists:highest_education,id',
            'mothers_occupation' => 'nullable|max:100',
            'mothers_religion_id' => 'nullable|exists:religions,id',
            'number_of_mothers_sibling' => 'nullable|integer',
            'income_id' => 'required|exists:incomes,id',
            'parents_status_id' => 'required|exists:parent_statuses,id',
            'incase_of_emergency_name' => 'required|max:100',
            'incase_of_emergency_contact' => 'required|digits:11',
            'kindergarten' => 'nullable',
            'kindergarten_year_attended' => 'nullable',
            'elementary' => 'required',
            'elementary_year_attended' => 'required|max:12',
            'junior_high' => 'required',
            'junior_high_year_attended' => 'required|max:12',
            'senior_high' => 'nullable',
            'senior_high_year_attended' => 'nullable',
            'pwd' => 'required|in:No,Yes',
            'pwd_remarks' => 'nullable|max:50',
            'ips' => 'required|in:No,Yes',
            'ips_remarks' => 'nullable|max:50',
            'solo_parent' => 'required|in:No,Yes',
            'course_id' => 'required|exists:courses,id',
            'year_id' => 'required|exists:years,id',
            'semester_id' => 'required|exists:semesters,id',
            'school_year_id' => 'required|exists:school_years,id',
            'current_province_id' => 'required|exists:provinces,prov_code',
            'current_municipality_id' => 'required|exists:municipalities,citymun_code',
            'current_barangay_id' => 'required|exists:baranggays,brgy_code',
            'current_purok' => 'nullable|string|max:100',
            'permanent_province_id' => 'required|exists:provinces,prov_code',
            'permanent_municipality_id' => 'required|exists:municipalities,citymun_code',
            'permanent_barangay_id' => 'required|exists:baranggays,brgy_code',
            'permanent_purok' => 'nullable|string|max:100',
            'fathers_province_id' => 'nullable|exists:provinces,prov_code',
            'fathers_municipality_id' => 'nullable|exists:municipalities,citymun_code',
            'fathers_barangay_id' => 'nullable|exists:baranggays,brgy_code',
            'fathers_purok' => 'nullable|string|max:100',
            'mothers_province_id' => 'nullable|exists:provinces,prov_code',
            'mothers_municipality_id' => 'nullable|exists:municipalities,citymun_code',
            'mothers_barangay_id' => 'nullable|exists:baranggays,brgy_code',
            'mothers_purok' => 'nullable|string|max:100',
        ]);

        $student = Student::findOrFail($id);

        $student->id_no = $request->input('id_no');
        $student->first_name = $request->input('first_name');
        $student->middle_name = $request->input('middle_name');
        $student->last_name = $request->input('last_name');
        $student->nick_name = $request->input('nick_name');
        $student->gender_id = $request->input('gender_id');
        $student->birthdate = $request->input('birthdate');
        $student->place_of_birth = $request->input('place_of_birth');
        $student->permanent_province_id = $request->input('permanent_province_id');
        $student->permanent_municipality_id = $request->input('permanent_municipality_id');
        $student->permanent_barangay_id = $request->input('permanent_barangay_id');
        $student->permanent_purok = $request->input('permanent_purok');
        $student->current_province_id = $request->input('current_province_id');
        $student->current_municipality_id = $request->input('current_municipality_id');
        $student->current_barangay_id = $request->input('current_barangay_id');
        $student->current_purok = $request->input('current_purok');
        $student->birth_order_among_sibling = $request->input('birth_order_among_sibling');
        $student->contact_no = $request->input('contact_no');
        $student->email_address = $request->input('email_address');
        $student->facebook_account = $request->input('facebook_account');
        $student->dialect_id = $request->input('dialect_id');
        $student->student_religion_id = $request->input('student_religion_id');
        $student->stay_id = $request->input('stay_id');
        $student->fathers_name = $request->input('fathers_name');
        $student->fathers_birthdate = $request->input('fathers_birthdate');
        $student->fathers_place_of_birth = $request->input('fathers_place_of_birth');
        $student->fathers_province_id = $request->input('fathers_province_id');
        $student->fathers_municipality_id = $request->input('fathers_municipality_id');
        $student->fathers_barangay_id = $request->input('fathers_barangay_id');
        $student->fathers_purok = $request->input('fathers_purok');
        $student->fathers_contact_no = $request->input('fathers_contact_no');
        $student->fathers_highest_education_id = $request->input('fathers_highest_education_id');
        $student->fathers_occupation = $request->input('fathers_occupation');
        $student->fathers_religion_id = $request->input('fathers_religion_id');
        $student->number_of_fathers_sibling = $request->input('number_of_fathers_sibling');
        $student->mothers_name = $request->input('mothers_name');
        $student->mothers_birthdate = $request->input('mothers_birthdate');
        $student->mothers_place_of_birth = $request->input('mothers_place_of_birth');
        $student->mothers_province_id = $request->input('mothers_province_id');
        $student->mothers_municipality_id = $request->input('mothers_municipality_id');
        $student->mothers_barangay_id = $request->input('mothers_barangay_id');
        $student->mothers_purok = $request->input('mothers_purok');
        $student->mothers_contact_no = $request->input('mothers_contact_no');
        $student->mothers_highest_education_id = $request->input('mothers_highest_education_id');
        $student->mothers_occupation = $request->input('mothers_occupation');
        $student->mothers_religion_id = $request->input('mothers_religion_id');
        $student->number_of_mothers_sibling = $request->input('number_of_mothers_sibling');
        $student->income_id = $request->input('income_id');
        $student->parents_status_id = $request->input('parents_status_id');
        $student->incase_of_emergency_name = $request->input('incase_of_emergency_name');
        $student->incase_of_emergency_contact = $request->input('incase_of_emergency_contact');
        $student->kindergarten_year_attended = $request->input('kindergarten_year_attended');
        $student->elementary = $request->input('elementary');
        $student->elementary_year_attended = $request->input('elementary_year_attended');
        $student->junior_high = $request->input('junior_high');
        $student->junior_high_year_attended = $request->input('junior_high_year_attended');
        $student->senior_high = $request->input('senior_high');
        $student->senior_high_year_attended = $request->input('senior_high_year_attended');
        $student->pwd = $request->input('pwd');
        $student->pwd_remarks = $request->input('pwd_remarks');
        $student->ips = $request->input('ips');
        $student->ips_remarks = $request->input('ips_remarks');
        $student->solo_parent = $request->input('solo_parent');
        $student->course_id = $request->input('course_id');
        $student->year_id = $request->input('year_id');
        $student->semester_id = $request->input('semester_id');
        $student->school_year_id = $request->input('school_year_id');

        $validatedData['age'] = Carbon::parse($validatedData['birthdate'])->age;

        $student->fill($validatedData);
        $student->save();

        if ($student) {
            session()->flash('success', 'Updated Successfully');
            return redirect()->route('admin.students.display');
        } else {
            session()->flash('error', 'Error occured');
            return redirect()->route('admin.students.edit');
        }
    }
    public function droppedStudent($id)
    {

        $students = Student::find($id);

        if ($students) {
            $students->status = "dropped";
            $students->save();

            session()->flash('success', 'Drop Successfully');
            return redirect()->route('admin.students.display');
        } else {
            session()->flash('error', 'Error occured');
            return redirect()->route('admin.students.display');
        }
    }

    public function activeStudent($id)
    {

        $students = Student::find($id);

        if ($students) {
            $students->status = "active";
            $students->save();

            session()->flash('success', 'Successfully');
            return redirect()->route('admin.students.display');
        } else {
            session()->flash('error', 'Error occured');
            return redirect()->route('admin.students.display');
        }
    }
    public function graduatedStudent($id)
    {

        $students = Student::find($id);

        if ($students) {
            $students->status = "graduated";
            $students->save();

            session()->flash('success', 'Save as Graduated in database');
            return redirect()->route('admin.students.display');
        } else {
            session()->flash('error', 'Error occured');
            return redirect()->route('admin.students.display');
        }
    }

    public function ipsDisplay()
    {

        $school_years = SchoolYear::all();

        $ipsData = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('ips', 'Yes')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.ips-student.display', compact('ipsData', 'school_years'));
    }

    public function pwdDisplay()
    {

        $school_years = SchoolYear::all();

        $pwdData = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('pwd', 'Yes')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.pwd-student.display', compact('pwdData', 'school_years'));
    }

    public function soloparentDisplay()
    {

        $school_years = SchoolYear::all();

        $soloparentData = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('solo_parent', 'Yes')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.solo-parent-student.display', compact('soloparentData', 'school_years'));
    }

    // public function getIpsStudents($school_year_id)
    // {
    //     $ipsData = Student::with('course', 'year', 'semester', 'school_year')
    //         ->where('school_year_id', $school_year_id)
    //         ->where('status', 'active')
    //         ->where('ips', 'Yes')
    //         ->get();

    //     return response()->json($ipsData);
    // }
    // public function getPwdStudents($school_year_id)
    // {
    //     $pwdData = Student::with('course', 'year', 'semester', 'school_year')
    //         ->where('school_year_id', $school_year_id)
    //         ->where('status', 'active')
    //         ->where('pwd', 'Yes')
    //         ->get();

    //     return response()->json($pwdData);
    // }
    public function delete($id)
    {
        $students = Student::find($id);

        if ($students) {
            $students->delete();
            return response()->json(['success' => true, 'message' => 'Student deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Student not found.']);
    }
    public function incomeFirstDisplay()
    {
        $below10k = Student::whereHas('income', function ($query) {
            $query->where('income_base', 'Below ₱10,000');
        })->with(['course', 'year', 'school_year'])
            ->where('status', 'active')
            ->orderBy('last_name', 'asc')
            ->get();

        $tenkToTwentyk = Student::whereHas('income', function ($query) {
            $query->where('income_base', '₱10,000-₱20,000');
        })->with(['course', 'year', 'school_year'])
            ->where('status', 'active')
            ->orderBy('last_name', 'asc')
            ->get();

        $twentykToThirtyk = Student::whereHas('income', function ($query) {
            $query->where('income_base', '₱20,000-₱30,000');
        })->with(['course', 'year', 'school_year'])
            ->where('status', 'active')
            ->orderBy('last_name', 'asc')
            ->get();

        $above30k = Student::whereHas('income', function ($query) {
            $query->where('income_base', 'Above ₱30,000');
        })->with(['course', 'year', 'school_year'])
            ->where('status', 'active')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.income-base-report.firstDisplay', compact('below10k', 'tenkToTwentyk', 'twentykToThirtyk', 'above30k'));
    }

    public function exportIpsPdf(Request $request)
    {
        // Fetch IPs data for the selected school year
        $ipsData = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('ips', 'Yes')
            ->get();

        $pdf = Pdf::loadView('admin.pdf.ips_pdf', compact('ipsData'));

        return $pdf->download('ips_students.pdf');
    }

    public function exportPwdPdf(Request $request)
    {
        $pwdData = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('pwd', 'Yes')
            ->get();

        $pdf = Pdf::loadView('admin.pdf.pwd_pdf', compact('pwdData'));

        return $pdf->download('pwd_students.pdf');
    }

    public function exportSoloparentPdf(Request $request)
    {
        $soloparentData = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('solo_parent', 'Yes')
            ->get();

        $pdf = Pdf::loadView('admin.pdf.soloparent_pdf', compact('soloparentData'));

        return $pdf->download('soloparent_students.pdf');
    }

    public function getActiveStudentsStats()
    {
        $activeStudents = DB::table('tbl_students')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('status', 'active')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($activeStudents);
    }

    public function ipsPrint()
    {

        $ipsData = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('ips', 'Yes')
            ->orderBy('course_id', 'asc')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.ips-student.print', compact('ipsData'));
    }

    public function pwdPrint()
    {

        $pwdData = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('pwd', 'Yes')
            ->orderBy('course_id', 'asc')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.pwd-student.print', compact('pwdData'));
    }
    public function soloParentPrint()
    {

        $soloparentData = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('solo_parent', 'Yes')
            ->orderBy('course_id', 'asc')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.solo-parent-student.print', compact('soloparentData'));
    }

    public function tenKPrint()
    {
        $belowTenK = Student::whereHas('income', function ($query) {
            $query->where('income_base', 'Below ₱10,000');
        })->with(['course', 'year', 'school_year'])
            ->where('status', 'active')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.income-base-report.print1', compact('belowTenK'));
    }
    public function tenKandtweentyKPrint()
    {

        $tenkToTwentyk = Student::whereHas('income', function ($query) {
            $query->where('income_base', '₱10,000-₱20,000');
        })->with(['course', 'year', 'school_year'])
            ->where('status', 'active')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.income-base-report.print2', compact('tenkToTwentyk'));
    }
    public function tweentyKandThirtyKPrint()
    {

        $twentykToThirtyk = Student::whereHas('income', function ($query) {
            $query->where('income_base', '₱20,000-₱30,000');
        })->with(['course', 'year', 'school_year'])
            ->where('status', 'active')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.income-base-report.print3', compact('twentykToThirtyk'));
    }
    public function aboveThirtyKPrint()
    {

        $above30k = Student::whereHas('income', function ($query) {
            $query->where('income_base', 'Above ₱30,000');
        })->with(['course', 'year', 'school_year'])
            ->where('status', 'active')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.income-base-report.print4', compact('above30k'));
    }
}
