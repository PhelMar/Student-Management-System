<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SchoolYear;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentRecord;
use App\Models\Violation;
use App\Models\ViolationsType;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

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

        return view('admin.student-violation.create', compact(
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
        $request->validate([
            'student_id' => 'required|exists:tbl_students,id_no',
            'violations_type_id' => 'required|exists:violations_type,id',
            'violations_date' => 'required|date',
            'remarks' => 'required|string|max:255',
            'course_id' => 'required|integer|min:1',
            'year_id' => 'required|integer|min:1',
            'semester_id' => 'required|integer|min:1',
            'school_year_id' => 'required|integer|min:1',
        ]);

        // Fetch student
        $student = Student::where('id_no', $request->student_id)->first();
        if (!$student) {
            return redirect()->back()->withErrors(['student_id' => 'Student not found.']);
        }

        // Calculate violations_level
        $lastViolation = Violation::where('student_id', $student->id)
            ->where('semester_id', $request->semester_id)
            ->where('school_year_id', $request->school_year_id)
            ->latest('created_at')
            ->first();

        $violationsLevel = $lastViolation ? ($lastViolation->violations_level + 1) : 1;

        // Insert violation using hidden inputs from the form
        Violation::create([
            'student_id' => $student->id,
            'violations_type_id' => $request->violations_type_id,
            'violations_date' => $request->violations_date,
            'remarks' => $request->remarks,
            'course_id' => $request->course_id,
            'year_id' => $request->year_id,
            'semester_id' => $request->semester_id,
            'school_year_id' => $request->school_year_id,
            'violations_level' => $violationsLevel,
        ]);

        return redirect()->route('admin.violations.display')->with('success', 'Violation recorded successfully.');
    }



    public function getStudent(Request $request)
    {
        $record = StudentRecord::with([
            'student:id,id_no,first_name,last_name,status',
            'course:id,course_name',
            'year:id,year_name',
            'semester:id,semester_name',
            'schoolYear:id,school_year_name',
        ])
            ->whereHas('student', function ($q) use ($request) {
                $q->where('id_no', $request->id_no)
                    ->whereNotIn('status', ['dropped', 'graduated']);
            })
            ->orderByDesc('school_year_id')
            ->orderByDesc('semester_id')
            ->first();

        if (!$record) {
            return response()->json(['message' => 'No student record found'], 404);
        }

        // Ensure IDs are integers and not null
        return response()->json([
            'student' => [
                'id_no'          => $record->student->id_no,
                'first_name'     => $record->student->first_name,
                'last_name'      => $record->student->last_name,

                'course'         => $record->course?->course_name ?? 'N/A',
                'course_id'      => $record->course?->id ?? 0,

                'year'           => $record->year?->year_name ?? 'N/A',
                'year_id'        => $record->year?->id ?? 0,

                'semester'       => $record->semester?->semester_name ?? 'N/A',
                'semester_id'    => $record->semester?->id ?? 0,

                'school_year'    => $record->schoolYear?->school_year_name ?? 'N/A',
                'school_year_id' => $record->schoolYear?->id ?? 0,
            ]
        ]);
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

        return view('admin.student-violation.display');
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
