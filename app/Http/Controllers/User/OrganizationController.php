<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Organization;
use App\Models\OrganizationType;
use App\Models\Position;
use App\Models\SchoolYear;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Year;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function create(Request $request)
    {

        $students = Student::all();
        $courses = Course::all();
        $years = Year::all();
        $semesters = Semester::all();
        $schoolYears = SchoolYear::all();
        $organizationTypes = OrganizationType::all();
        $positions = Position::all();

        return view('users.student-organization.create', compact(
            'students',
            'courses',
            'years',
            'semesters',
            'schoolYears',
            'organizationTypes',
            'positions'
        ));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'student_id' => 'required|exists:tbl_students,id_no',
            'organization_types_id' => 'required|exists:organization_types,id',
            'organization_date' => 'required|date',
            'course_id' => 'required|exists:courses,id',
            'year_id' => 'required|exists:years,id',
            'semester_id' => 'required|exists:semesters,id',
            'school_year_id' => 'required|exists:school_years,id',
            'positions_id' => 'required|exists:positions,id',
        ]);

        $organizationData = Organization::create($validateData);

        if ($organizationData) {
            return redirect()->route('user.organizations.display')
                ->with('success', 'Organization recorded successfully.');
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
        $organizationData = Organization::with([
            'organizationType',
            'position',
            'course',
            'year',
            'semester',
            'school_year'
        ])
            ->orderBy('organization_date', 'desc')
            ->get();

        return view('users.student-organization.display', compact('organizationData'));
    }

    public function delete($id)
    {
        $organization = Organization::find($id);

        if ($organization) {
            $organization->delete();
            return response()->json(['success' => true, 'message' => 'Organization deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Organization not found.']);
    }
}
