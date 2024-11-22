<?php

namespace App\Http\Controllers\Guard;

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

class ViolationsController extends Controller
{
    public function create(Request $request)
    {

        $violationsType = ViolationsType::all();
        $students = Student::all();
        $courses = Course::all();
        $years = Year::all();
        $semesters = Semester::all();
        $schoolYears = SchoolYear::all();

        return view('guard.student-violation.create', compact(
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
            return redirect()->route('guard.violations.display')
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
    public function display()
    {

        $violations = Violation::with(['violationType', 'course', 'year', 'semester', 'school_year'])
            ->orderBy('violations_date', 'desc')
            ->orderBy('violations_level', 'desc')
            ->get();

        return view('guard.student-violation.display', compact('violations'));
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
