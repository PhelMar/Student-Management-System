<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SchoolYear;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Violation;
use App\Models\ViolationsType;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;
use Yajra\DataTables\Facades\DataTables;

class ViolationController extends Controller
{
    public function create(Request $request)
    {

        $violationsType = ViolationsType::all();
        $students = Student::all();
        $courses = Course::all();
        $years = Year::all();
        $semesters = Semester::all();
        $schoolYears = SchoolYear::all();

        return view('users.student-violation.create', compact(
            'students',
            'courses',
            'years',
            'semesters',
            'schoolYears',
            'violationsType'
        ));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'student_id' => 'required|exists:tbl_students,id_no',
            'violations_type_id' => 'required|exists:violations_type,id',
            'violations_date' => 'required|date',
            'remarks' => 'required',
            'course_id' => 'required|exists:courses,id',
            'year_id' => 'required|exists:years,id',
            'semester_id' => 'required|exists:semesters,id',
            'school_year_id' => 'required|exists:school_years,id'
        ]);

        $lastViolation = Violation::where('student_id', $request->student_id)
            ->latest('created_at')
            ->first();

        $violationsLevel = 1;

        if ($lastViolation) {
            if ($lastViolation->semester_id == $request->semester_id && $lastViolation->school_year_id == $request->school_year_id) {

                $violationsLevel = $lastViolation->violations_level + 1;
            }
        }

        $violations = Violation::create(array_merge($validateData, [
            'violations_level' => $violationsLevel,
        ]));

        if ($violations) {
            return redirect()->route('user.violations.display')
                ->with('success', 'Violation recorded successfully.');
        }
    }



    public function getStudent(Request $request)
    {
        $student = Student::where('id_no', $request->id_no)
            ->whereNotIn('status', ['dropped', 'graduated'])
            ->with('course', 'year', 'semester', 'school_year')
            ->first();

        if ($student) {
            return response()->json([
                'student' => $student,
                'course' => $student->course->id,
                'year' => $student->year->id,
                'semester' => $student->semester->id,
                'school_year' => $student->school_year->id,
            ]);
        }
        return response()->json(['message' => 'Student not found'], 404);
    }
    public function display(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50',
        ]);
        if ($request->ajax()) {

            $search = $request->input('search.value', '');

            $query = Violation::with([
                'violationType:id,violation_type_name',
                'course:id,course_name',
                'year:id,year_name',
                'semester:id,semester_name',
                'school_year:id,school_year_name',
                'student:id,id_no,last_name,first_name',
            ])
                ->orderBy('violations_date', 'desc')
                ->orderBy('violations_level', 'desc');

            if ($search) {
                $query->whereHas('student', function ($q) use ($search) {
                    $q->whereRaw("CAST(id_no AS CHAR) LIKE ?", ["%{$search}%"])
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
                $query->orWhereHas('course', function ($q) use ($search) {
                    $q->where('course_name', 'like', "%{$search}%");
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
                        'id_no' => $row->student->id_no ?? 'N/A',
                        'name' => $row->student ? $row->student->last_name . ', ' . $row->student->first_name : 'N/A',
                        'course_name' => $row->course->course_name ?? 'N/A',
                        'year_name' => $row->year->year_name ?? 'N/A',
                        'semester_name' => $row->semester->semester_name ?? 'N/A',
                        'school_year_name' => $row->school_year->school_year_name ?? 'N/A',
                        'violation_type_name' => $row->violationType ? $row->violationType->violation_type_name : 'N/A',
                        'violations_level' => $row->violations_level,
                        'remarks' => $row->remarks,
                        'violations_date' => $row->violations_date,
                    ];
                }),
            ]);
        }

        return view('users.student-violation.display');
    }


    public function getViolationsData()
    {
        $violationsData = DB::table('violations')
            ->select(DB::raw('DATE(violations_date) as date'), DB::raw('count(*) as total_violations'))
            ->groupBy(DB::raw('DATE(violations_date)'))
            ->orderBy('date', 'asc')
            ->get();

        // Return data as JSON for JavaScript to use
        return response()->json($violationsData);
    }

    public function getBarViolationsData()
    {
        $violations = DB::table('violations')
            ->select(DB::raw('MONTH(violations_date) as month'), DB::raw('YEAR(violations_date) as year'), DB::raw('count(*) as violations'))
            ->groupBy(DB::raw('MONTH(violations_date)'), DB::raw('YEAR(violations_date)'))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $formattedViolations = $violations->map(function ($item) {
            return [
                'month' => \Carbon\Carbon::createFromFormat('m', $item->month)->format('F'),
                'violations' => $item->violations
            ];
        });

        return response()->json($formattedViolations);
    }
}
