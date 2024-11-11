<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Clearance;
use App\Models\Course;
use App\Models\SchoolYear;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Year;
use Illuminate\Http\Request;

class ClearancesController extends Controller
{
    public function create(Request $request)
    {
        $courses = Course::all();
        $years = Year::all();
        $semesters = Semester::all();
        $school_years = SchoolYear::all();

        return view('users.student-clearance.create', compact(
            'courses',
            'years',
            'semesters',
            'school_years'
        ));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'student_id' => 'required|exists:tbl_students,id_no',
            'course_id' => 'required|exists:courses,id',
            'year_id' => 'required|exists:years,id',
            'semester_id' => 'required|exists:semesters,id',
            'school_year_id' => 'required|exists:school_years,id',
            'control_no' => 'required|unique:tbl_clearances,control_no'
        ]);

        $clearanceData = Clearance::create($validateData);

        if ($clearanceData) {
            return redirect()->route('user.clearance.display')
                ->with('success', 'Clearance recorded successfully.');
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

        return response()->json(['message' => 'Student not Found'], 404);
    }

    public function display()
    {

        $clearanceData = Clearance::with(['course', 'year', 'semester', 'school_year'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('users.student-clearance.display', compact('clearanceData'));
    }
    public function clearedStudent($id)
    {
        $clearance = Clearance::find($id);

        if ($clearance) {
            $clearance->status = 'cleared';
            $clearance->save();

            return response()->json(['success' => true, 'message' => 'Cleared student successfully saved!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Error occurred while clearing student.']);
        }
    }
}
