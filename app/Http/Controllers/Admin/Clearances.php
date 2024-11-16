<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clearance;
use App\Models\Course;
use App\Models\SchoolYear;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Clearances extends Controller
{
    public function create(Request $request)
    {
        $courses = Course::all();
        $years = Year::all();
        $semesters = Semester::all();
        $school_years = SchoolYear::all();

        return view('admin.student-clearance.create', compact(
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
            'control_no' => [
                'required',
                Rule::unique('tbl_clearances')->where(function ($query) use ($request) {
                    return $query->where('semester_id', $request->semester_id)
                        ->where('school_year_id', $request->school_year_id);
                })
            ]
        ]);

        $clearanceData = Clearance::create($validateData);

        if ($clearanceData) {
            return redirect()->route('admin.clearance.display')
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

        return view('admin.student-clearance.display', compact('clearanceData'));
    }

    public function clearedStudentDisplay()
    {
        $BSIT = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSIT');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        $BSBA_MM = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSBA MM');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        $BSTM = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSTM');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        $BSBA_FM = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSBA FM');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        $BEED = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BEED');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();
        $BSED_VALUES = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSED VALUES');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        $BSED_SOCIAL_STUDIES = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSED SOCIAL STUDIES');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        $BSED_ENGLISH = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSED ENGLISH');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();


        $BSCRIM = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSCRIM');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        return view('admin.student-clearance.clearedClearance', compact(
            'BSIT',
            'BSTM',
            'BSBA_FM',
            'BSBA_MM',
            'BEED',
            'BSED_ENGLISH',
            'BSED_VALUES',
            'BSED_SOCIAL_STUDIES',
            'BSCRIM'
        ));
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
