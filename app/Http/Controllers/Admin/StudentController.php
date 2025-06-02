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
use Exception;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Validation\Rule;

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
        $provinces = Province::orderBy('prov_desc', 'asc')->get();

        $latest_school_year = DB::table('school_years')
        ->orderBy('school_year_name', 'desc')
        ->first();


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
            'provinces',
            'latest_school_year'
        ));
    }

    public function createStudent()
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
        $provinces = Province::orderBy('prov_desc', 'asc')->get();

        $latest_school_year = DB::table('school_years')
        ->orderBy('school_year_name', 'desc')
        ->first();


        return view('add-student.create', compact(
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
            'provinces',
            'latest_school_year'
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

    public function countFourPsStudents()
    {

        $fourps = Student::where('four_ps', 'Yes')->count();
        return response()->json(['count' => $fourps]);
    }
    public function countScholarStudents()
    {

        $scholar = Student::where('scholarship', 'Yes')->count();
        return response()->json(['count' => $scholar]);
    }

    public function countActiveStudents()
    {
        $activeCount = Student::where('status', 'active')->count();
        return response()->json(['count' => $activeCount]);
    }
    public function getMunicipalStudentCount()
    {
        $municipalityCounts = Student::select('current_municipality_id', DB::raw('count(*) as count'))
            ->groupBy('current_municipality_id')
            ->get();

        // Prepare an array to hold the municipality name and its student count
        $municipalityStudentCounts = [];

        foreach ($municipalityCounts as $count) {
            // Retrieve the municipality name using the 'current_municipality_id'
            $municipality = Municipality::where('citymun_code', trim($count->current_municipality_id))->first();
            $municipalityStudentCounts[] = [
                'municipality' => $municipality ? $municipality->citymun_desc : 'Unknown',
                'count' => $count->count,
            ];
        }

        return response()->json($municipalityStudentCounts);
    }




    public function display(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);

        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = Student::select('id', 'id_no', 'first_name', 'last_name', 'course_id', 'year_id', 'semester_id', 'school_year_id')
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                ])
                ->where('status', 'active') // Always filter by active status
                ->orderBy('created_at', 'desc');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw("CAST(id_no AS CHAR) LIKE ?", ["%{$search}%"])
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhereHas('course', function ($query) use ($search) {
                            $query->where('course_name', 'like', "%{$search}%");
                        });
                });
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'id_no' => $row->id_no,
                        'name' => $row->last_name . ', ' . $row->first_name,
                        'course_name' => $row->course ? $row->course->course_name : 'N/A',
                        'year_name' => $row->year ? $row->year->year_name : 'N/A',
                        'semester_name' => $row->semester ? $row->semester->semester_name : 'N/A',
                        'school_year_name' => $row->school_year ? $row->school_year->school_year_name : 'N/A',
                        'hashed_id' => Hashids::encode($row->id),
                    ];
                }),
            ]);
        }
        $school_year = DB::table('school_years')->pluck('school_year_name', 'id');
        $semester = DB::table('semesters')->pluck('semester_name', 'id');
        $courses = Course::all();
        $years = Year::all();
        return view('admin.student-profile.display', compact(
            'courses',
            'years',
            'semester',
            'school_year',
        ));
    }

    public function printStudents(Request $request)
    {
        $courseId = $request->query('course');
        $yearId = $request->query('year');

        $request->validate([
            'course' => 'required|exists:courses,id',
            'year' => 'required|exists:years,id',
        ]);

        $students = Student::with(['course', 'year', 'semester', 'school_year'])
            ->where('course_id', $courseId)
            ->where('year_id', $yearId)
            ->where('status', 'active') // Filter only active students
            ->get();

        return view('admin.printStudents.print', [
            'studentsData' => $students,
            'courseName' => Course::find($courseId)->course_name,
            'yearName' => Year::find($yearId)->year_name,
        ]);
    }




    public function dropStudentDisplay(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);

        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = Student::select('id', 'id_no', 'first_name', 'last_name', 'course_id', 'year_id', 'semester_id', 'school_year_id')
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                ])
                ->where('status', 'dropped') // Filter by dropped students
                ->orderBy('created_at', 'desc');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw("CAST(id_no AS CHAR) LIKE ?", ["%{$search}%"])
                        ->orwhere('last_name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhereHas('course', function ($query) use ($search) {
                            $query->where('course_name', 'like', "%{$search}%");
                        });
                });
            }


            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'id_no' => $row->id_no,
                        'name' => $row->last_name . ', ' . $row->first_name,
                        'course_name' => $row->course ? $row->course->course_name : 'N/A',
                        'year_name' => $row->year ? $row->year->year_name : 'N/A',
                        'semester_name' => $row->semester ? $row->semester->semester_name : 'N/A',
                        'school_year_name' => $row->school_year ? $row->school_year->school_year_name : 'N/A',
                        'hashed_id' => Hashids::encode($row->id),
                    ];
                }),
            ]);
        }

        return view('admin.student-profile.drop-student.display');
    }


    public function show($hashId)
    {
        $id = Hashids::decode($hashId)[0] ?? null;

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
            ->findOrFail($id);

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
            'single_mom' => [
        'nullable',
        Rule::in(['No', 'Yes']),
        Rule::requiredIf(function () use ($request) {
            $gender = Gender::find($request->gender_id);
            return $gender && strtolower($gender->gender_name) === 'female';
        }),
    ],
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
            'four_ps' => 'required|in:No,Yes',
            'scholarship' => 'required|in:No,Yes',
            'scholarship_remarks' => 'nullable|max:100',
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

    public function storeStudent(Request $request)
    {

        $validatedData = $request->validate([
            'id_no' => 'required|digits:10|unique:tbl_students,id_no',
            'first_name' => 'required|max:40',
            'middle_name' => 'nullable|max:40',
            'last_name' => 'required|max:40',
            'nick_name' => 'nullable|max:40',
            'gender_id' => 'required|exists:genders,id',
            'single_mom' => [
        'nullable',
        Rule::in(['No', 'Yes']),
        Rule::requiredIf(function () use ($request) {
            $gender = Gender::find($request->gender_id);
            return $gender && strtolower($gender->gender_name) === 'female';
        }),
    ],
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
            'four_ps' => 'required|in:No,Yes',
            'scholarship' => 'required|in:No,Yes',
            'scholarship_remarks' => 'nullable|max:100',
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
            return redirect()->route('admin.students.createStudent');
        } else {
            session()->flash('error', 'Error occured');
            return redirect()->route('admin.students.createStudent');
        }
    }
    public function edit($hashId)
    {
        try {

            $id = Hashids::decode($hashId)[0] ?? null;

            if (!$id) {
                throw new Exception('Invalid ID');
            }

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
            $provinces = Province::orderBy('prov_desc', 'asc')->get();
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
        } catch (Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    public function StudentView($hashId)
    {
        $id = Hashids::decode($hashId)[0] ?? null;

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
    public function update(Request $request, $hashId)
    {
        try {
            $id = Hashids::decode($hashId)[0] ?? null;
            $rules = [
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
                'four_ps' => 'required|in:No,Yes',
                'scholarship' => 'required|in:No,Yes',
                'scholarship_remarks' => 'nullable|max:100',
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
            ];

            if ($request->gender_id) {
                $gender = Gender::find($request->gender_id);
                if ($gender && strtolower($gender->gender_name) === 'female') {
                    $rules['single_mom'] = ['required', Rule::in(['Yes', 'No'])];
                } else {
                    $rules['single_mom'] = ['nullable', Rule::in(['Yes', 'No'])];
                }
            }

            $validatedData = $request->validate($rules);


            $student = Student::findOrFail($id);

            $student->id_no = $request->input('id_no');
            $student->first_name = $request->input('first_name');
            $student->middle_name = $request->input('middle_name');
            $student->last_name = $request->input('last_name');
            $student->nick_name = $request->input('nick_name');
            $student->gender_id = $request->input('gender_id');
            $student->single_mom = $request->input('single_mom');
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
            $student->four_ps = $request->input('four_ps');
            $student->scholarship = $request->input('scholarship');
            $student->scholarship_remarks = $request->input('scholarship_remarks');
            $student->course_id = $request->input('course_id');
            $student->year_id = $request->input('year_id');
            $student->semester_id = $request->input('semester_id');
            $student->school_year_id = $request->input('school_year_id');

            $validatedData['age'] = Carbon::parse($validatedData['birthdate'])->age;

            $student->update($validatedData);

            if ($student) {
                session()->flash('success', 'Updated Successfully');
                return redirect()->route('admin.students.display');
            } else {
                session()->flash('error', 'Error occured');
                return redirect()->route('admin.students.edit');
            }
        } catch (Exception $e) {
            return redirect()->route('admin.students.display')->with('error', 'Failed to update student' . $e->getMessage());
        }
    }
    public function droppedStudent($hashId)
    {

        try {
            $id = Hashids::decode($hashId)[0] ?? null;

            if (!$id) {
                throw new Exception('Invalid ID');
            }

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
        } catch (Exception $e) {
            return redirect()->route('admin.students.display')->with('error', 'Failed to drop the student. ' . $e->getMessage());
        }
    }

    public function activeStudent($hashId)
    {
        $id = Hashids::decode($hashId)[0] ?? null;

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

    public function ipsDisplay(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);

        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = Student::select('id', 'id_no', 'first_name', 'last_name', 'course_id', 'year_id', 'semester_id', 'school_year_id', 'ips_remarks')
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                ])
                ->where('status', 'active')
                ->where('ips', 'Yes')
                ->orderBy('last_name', 'asc');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('last_name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhereHas('course', function ($query) use ($search) {
                            $query->where('course_name', 'like', "%{$search}%");
                        });
                });
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'last_name' => $row->last_name,
                        'first_name' => $row->first_name,
                        'course_name' => $row->course ? $row->course->course_name : 'N/A',
                        'year_name' => $row->year ? $row->year->year_name : 'N/A',
                        'semester_name' => $row->semester ? $row->semester->semester_name : 'N/A',
                        'school_year_name' => $row->school_year ? $row->school_year->school_year_name : 'N/A',
                        'ips_remarks' => $row->ips_remarks ?? 'N/A',
                    ];
                }),
            ]);
        }

        $school_years = SchoolYear::all();
        return view('admin.ips-student.display', compact('school_years'));
    }


    public function pwdDisplay(Request $request)
    {

        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);

        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = Student::select('id', 'id_no', 'first_name', 'last_name', 'course_id', 'year_id', 'semester_id', 'school_year_id', 'pwd_remarks')
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                ])
                ->where('status', 'active')
                ->where('pwd', 'Yes')
                ->orderBy('last_name', 'asc');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('last_name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhereHas('course', function ($query) use ($search) {
                            $query->where('course_name', 'like', "%{$search}%");
                        });
                });
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'last_name' => $row->last_name,
                        'first_name' => $row->first_name,
                        'course_name' => $row->course ? $row->course->course_name : 'N/A',
                        'year_name' => $row->year ? $row->year->year_name : 'N/A',
                        'semester_name' => $row->semester ? $row->semester->semester_name : 'N/A',
                        'school_year_name' => $row->school_year ? $row->school_year->school_year_name : 'N/A',
                        'pwd_remarks' => $row->pwd_remarks ?? 'N/A',
                    ];
                }),
            ]);
        }

        $school_years = SchoolYear::all();
        return view('admin.pwd-student.display', compact('school_years'));
    }

    public function fourpsDisplay(Request $request)
    {

        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);

        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = Student::select('id', 'id_no', 'first_name', 'last_name', 'course_id', 'year_id', 'semester_id', 'school_year_id')
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                ])
                ->where('status', 'active')
                ->where('four_ps', 'Yes')
                ->orderBy('last_name', 'asc');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('last_name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhereHas('course', function ($query) use ($search) {
                            $query->where('course_name', 'like', "%{$search}%");
                        });
                });
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'last_name' => $row->last_name,
                        'first_name' => $row->first_name,
                        'course_name' => $row->course ? $row->course->course_name : 'N/A',
                        'year_name' => $row->year ? $row->year->year_name : 'N/A',
                        'semester_name' => $row->semester ? $row->semester->semester_name : 'N/A',
                        'school_year_name' => $row->school_year ? $row->school_year->school_year_name : 'N/A',
                    ];
                }),
            ]);
        }

        $school_years = SchoolYear::all();
        return view('admin.four-ps-student.display', compact('school_years'));
    }

    public function scholarDisplay(Request $request)
    {

        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);

        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = Student::select('id', 'id_no', 'first_name', 'last_name', 'course_id', 'year_id', 'semester_id', 'school_year_id', 'scholarship_remarks')
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                ])
                ->where('status', 'active')
                ->where('scholarship', 'Yes')
                ->orderBy('last_name', 'asc');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('last_name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhereHas('course', function ($query) use ($search) {
                            $query->where('course_name', 'like', "%{$search}%");
                        });
                });
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'last_name' => $row->last_name,
                        'first_name' => $row->first_name,
                        'course_name' => $row->course ? $row->course->course_name : 'N/A',
                        'year_name' => $row->year ? $row->year->year_name : 'N/A',
                        'semester_name' => $row->semester ? $row->semester->semester_name : 'N/A',
                        'school_year_name' => $row->school_year ? $row->school_year->school_year_name : 'N/A',
                        'scholarship_remarks' => $row->scholarship_remarks,
                    ];
                }),
            ]);
        }

        $school_years = SchoolYear::all();
        return view('admin.scholar-student.display', compact('school_years'));
    }

    public function soloparentDisplay(Request $request)
    {

        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);

        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = Student::select('id', 'id_no', 'first_name', 'last_name', 'course_id', 'year_id', 'semester_id', 'school_year_id', 'ips_remarks')
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                ])
                ->where('status', 'active')
                ->where('solo_parent', 'Yes')
                ->orderBy('last_name', 'asc');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('last_name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhereHas('course', function ($query) use ($search) {
                            $query->where('course_name', 'like', "%{$search}%");
                        });
                });
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'last_name' => $row->last_name,
                        'first_name' => $row->first_name,
                        'course_name' => $row->course ? $row->course->course_name : 'N/A',
                        'year_name' => $row->year ? $row->year->year_name : 'N/A',
                        'semester_name' => $row->semester ? $row->semester->semester_name : 'N/A',
                        'school_year_name' => $row->school_year ? $row->school_year->school_year_name : 'N/A',
                    ];
                }),
            ]);
        }

        $school_years = SchoolYear::all();
        return view('admin.solo-parent-student.display', compact('school_years'));
    }
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
        return view('admin.income-base-report.firstDisplay');
    }

    public function belowTenK(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);

        if ($request->ajax()) {
            $query = Student::whereHas('income', function ($q) {
                $q->where('income_base', 'Below ₱10,000');
            })->with(['course:id,course_name', 'year:id,year_name', 'school_year:id,school_year_name'])
                ->where('status', 'active')
                ->orderBy('last_name', 'asc');

            $totalData = $query->count();

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $search = $request->input('search.value', '');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhereHas('course', function ($query) use ($search) {
                            $query->where('course_name', 'like', "%{$search}%");
                        });
                });
            }

            $filteredData = $query->count();
            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $filteredData,
                'data' => $data->map(function ($student, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'student_name' => "{$student->last_name}, {$student->first_name}",
                        'course_name' => $student->course->course_name ?? 'N/A',
                        'year_name' => $student->year->year_name ?? 'N/A',
                        'school_year_name' => $student->school_year->school_year_name ?? 'N/A',
                    ];
                }),
            ]);
        }

        return view('admin.income-base-report.firstDisplay');
    }
    public function betweenTenAndTwenty(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);

        if ($request->ajax()) {
            $query = Student::whereHas('income', function ($q) {
                $q->where('income_base', '₱10,000-₱20,000');
            })->with(['course:id,course_name', 'year:id,year_name', 'school_year:id,school_year_name'])
                ->where('status', 'active')
                ->orderBy('last_name', 'asc');

            $totalData = $query->count();

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $search = $request->input('search.value', '');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhereHas('course', function ($query) use ($search) {
                            $query->where('course_name', 'like', "%{$search}%");
                        });
                });
            }

            $filteredData = $query->count();
            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $filteredData,
                'data' => $data->map(function ($student, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'student_name' => "{$student->last_name}, {$student->first_name}",
                        'course_name' => $student->course->course_name ?? 'N/A',
                        'year_name' => $student->year->year_name ?? 'N/A',
                        'school_year_name' => $student->school_year->school_year_name ?? 'N/A',
                    ];
                }),
            ]);
        }

        return view('admin.income-base-report.firstDisplay');
    }

    public function betweenTwentyAndThirty(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);

        if ($request->ajax()) {
            $query = Student::select('id', 'id_no', 'first_name', 'last_name', 'course_id', 'year_id', 'semester_id', 'school_year_id')
                ->whereHas('income', function ($q) {
                    $q->where('income_base', '₱20,000-₱30,000');
                })->with(['course:id,course_name', 'year:id,year_name', 'school_year:id,school_year_name'])
                ->where('status', 'active')
                ->orderBy('last_name', 'asc');

            $totalData = $query->count();

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $search = $request->input('search.value', '');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhereHas('course', function ($query) use ($search) {
                            $query->where('course_name', 'like', "%{$search}%");
                        });
                });
            }

            $filteredData = $query->count();
            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $filteredData,
                'data' => $data->map(function ($student, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'student_name' => "{$student->last_name}, {$student->first_name}",
                        'course_name' => $student->course->course_name ?? 'N/A',
                        'year_name' => $student->year->year_name ?? 'N/A',
                        'school_year_name' => $student->school_year->school_year_name ?? 'N/A',
                    ];
                }),
            ]);
        }

        return view('admin.income-base-report.firstDisplay');
    }
    public function aboveThirty(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);

        if ($request->ajax()) {
            $query = Student::select('id', 'id_no', 'first_name', 'last_name', 'course_id', 'year_id', 'semester_id', 'school_year_id')
                ->whereHas('income', function ($q) {
                    $q->where('income_base', 'Above ₱30,000');
                })->with(['course:id,course_name', 'year:id,year_name', 'school_year:id,school_year_name'])
                ->where('status', 'active')
                ->orderBy('last_name', 'asc');

            $totalData = $query->count();

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $search = $request->input('search.value', '');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhereHas('course', function ($query) use ($search) {
                            $query->where('course_name', 'like', "%{$search}%");
                        });
                });
            }

            $filteredData = $query->count();
            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $filteredData,
                'data' => $data->map(function ($student, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'student_name' => "{$student->last_name}, {$student->first_name}",
                        'course_name' => $student->course->course_name ?? 'N/A',
                        'year_name' => $student->year->year_name ?? 'N/A',
                        'school_year_name' => $student->school_year->school_year_name ?? 'N/A',
                    ];
                }),
            ]);
        }

        return view('admin.income-base-report.firstDisplay');
    }

    public function exportIpsPdf(Request $request)
    {
        $schoolYearId = $request->input('school_year_id');

        $query = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('ips', 'Yes');

        if ($schoolYearId) {
            $query->where('school_year_id', $schoolYearId);
        }

        $ipsData = $query
        ->orderBy('course_id', 'asc')
        ->orderBy('last_name')->get();

        $pdf = Pdf::loadView('admin.pdf.ips_pdf', compact('ipsData'));

        return $pdf->download('ips_students.pdf');
    }

    public function exportPwdPdf(Request $request)
    {
        $schoolYearId = $request->input('school_year_id');

        $query = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('pwd', 'Yes');

        if ($schoolYearId) {
            $query->where('school_year_id', $schoolYearId);
        }

        $pwdData = $query
        ->orderBy('course_id', 'asc')
        ->orderBy('last_name')->get();

        $pdf = Pdf::loadView('admin.pdf.pwd_pdf', compact('pwdData'));

        return $pdf->download('pwd_students.pdf');
    }

    public function exportFourPsPdf(Request $request)
    {
        $schoolYearId = $request->input('school_year_id');

        $query = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('four_ps', 'Yes');

        if ($schoolYearId) {
            $query->where('school_year_id', $schoolYearId);
        }

        $fourpsData = $query
        ->orderBy('course_id', 'asc')
        ->orderBy('last_name')->get();

        $pdf = Pdf::loadView('admin.pdf.four_ps_pdf', compact('fourpsData'));

        return $pdf->download('4ps_students.pdf');
    }

    public function exportScholarPdf(Request $request)
    {
        $schoolYearId = $request->input('school_year_id');

        $query = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('scholarship', 'Yes');
        
            if ($schoolYearId){
                $query->where('school_year_id', $schoolYearId);
            }

        $scholarData = $query
        ->orderBy('course_id', 'asc')
        ->orderBy('last_name')->get();

        $pdf = Pdf::loadView('admin.pdf.scholar_student_pdf', compact('scholarData'));

        return $pdf->download('Scholar_student.pdf');
    }

    public function exportSoloparentPdf(Request $request)
{
    $schoolYearId = $request->input('school_year_id');

    $query = Student::with('course', 'year', 'semester', 'school_year')
        ->where('status', 'active')
        ->where('solo_parent', 'Yes');

    if ($schoolYearId) {
        $query->where('school_year_id', $schoolYearId);
    }

    $soloparentData = $query
    ->orderBy('course_id', 'asc')
    ->orderBy('last_name')->get();

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


    public function generateStudentsReport(Request $request){

        $schoolYearId = $request->school_year_id;
        $semesterId = $request->semester_id;

        $rawData = Student::selectRaw('courses.course_name as course, years.year_name as year_level, COUNT(*) as total')
        ->join('courses', 'tbl_students.course_id', '=', 'courses.id')
        ->join('years', 'tbl_students.year_id', '=', 'years.id')
        ->where('tbl_students.status', 'active')
        ->where('tbl_students.school_year_id', $schoolYearId)
        ->where('tbl_students.semester_id', $semesterId)
        ->groupBy('courses.course_name', 'years.year_name')
        ->orderBy('courses.course_name')
        ->get();

    $report = [];
    $overallTotal = 0;

    foreach ($rawData as $row) {
        $course = $row->course;
        $year = $row->year_level;
        $count = $row->total;

        if (!isset($report[$course])) {
            $report[$course] = [
                '1st Year' => 0,
                '2nd Year' => 0,
                '3rd Year' => 0,
                '4th Year' => 0,
                'total' => 0
            ];
        }

        $report[$course][$year] = $count;
        $report[$course]['total'] += $count;
        $overallTotal += $count;
    }

    // Handle view or PDF/Print
    $action = $request->input('action');

    if ($action === 'pdf') {
        $pdf = PDF::loadView('admin.total_students_report.pdf', compact('report', 'overallTotal'));
        return $pdf->stream('Student_Report.pdf');
    } elseif ($action === 'print') {
        return view('admin.total_students_report.print', compact('report', 'overallTotal'));
    }

    return view('admin.reportResult', compact('report', 'overallTotal'));
    }

    public function ipsPrint(Request $request)
    {
        $schoolYearId = $request->input('school_year_id');

        $query = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('ips', 'Yes');
            
        if($schoolYearId) {
            $query->where('school_year_id', $schoolYearId);
        }
        $ipsData = $query
            ->orderBy('course_id', 'asc')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.ips-student.print', compact('ipsData'));
    }

    public function pwdPrint(Request $request)
    {
        $schoolYearId = $request->input('school_year_id');

        $query = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('pwd', 'Yes');

        if ($schoolYearId) {
            $query->where('school_year_id', $schoolYearId);
        }

        $pwdData = $query
            ->orderBy('course_id', 'asc')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.pwd-student.print', compact('pwdData'));
    }

    public function fourpsPrint(Request $request)
    {
        $schoolYearId = $request->input('school_year_id');

        $query = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('four_ps', 'Yes');
            
        
        if ($schoolYearId) {
            $query->where('school_year_id', $schoolYearId);
        }

        $fourpsData = $query
            ->orderBy('course_id', 'asc')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('admin.four-ps-student.print', compact('fourpsData'));
    }

    public function scholarPrint(Request $request)
    {
        $schoolYearId = $request->input('school_year_id');

        $query = Student::with('course', 'year', 'semester', 'school_year')
            ->where('status', 'active')
            ->where('scholarship', 'Yes');
        
        if ($schoolYearId) {
            $query->where('school_year_id', $schoolYearId);
        }

        $scholarData = $query
        ->orderBy('course_id', 'asc')
        ->orderBy('last_name', 'asc')
        ->get();

        return view('admin.scholar-student.print', compact('scholarData'));
    }
    public function soloParentPrint(Request $request)
{
    $schoolYearId = $request->input('school_year_id');

    $query = Student::with('course', 'year', 'semester', 'school_year')
        ->where('status', 'active')
        ->where('solo_parent', 'Yes');

    if ($schoolYearId) {
        $query->where('school_year_id', $schoolYearId);
    }

    $soloparentData = $query
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