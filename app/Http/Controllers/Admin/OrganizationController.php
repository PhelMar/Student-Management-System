<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SchoolHelper;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Organization;
use App\Models\OrganizationType;
use App\Models\Position;
use App\Models\SchoolYear;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentRecord;
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

        return view('admin.student-organization.create', compact(
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
            return redirect()->route('admin.organizations.display')
                ->with('success', 'Organization recorded successfully.');
        }
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

        return response()->json([
            'student' => [
                'id_no'          => $record->student->id_no,
                'first_name'     => $record->student->first_name,
                'last_name'      => $record->student->last_name,

                // ✅ flatten values
                'course'         => $record->course?->course_name ?? 'N/A',
                'course_id'      => $record->course?->id ?? null,

                'year'           => $record->year?->year_name ?? 'N/A',
                'year_id'        => $record->year?->id ?? null,

                'semester'       => $record->semester?->semester_name ?? 'N/A',
                'semester_id'    => $record->semester?->id ?? null,

                'school_year'    => $record->schoolYear?->school_year_name ?? 'N/A',
                'school_year_id' => $record->schoolYear?->id ?? null,
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

            $query = Organization::with([
                'organizationType:id,organization_name',
                'position:id,positions_name',
                'course:id,course_name',
                'year:id,year_name',
                'semester:id,semester_name',
                'school_year:id,school_year_name',
                'student:id,id_no,last_name,first_name',
            ])
                ->orderBy('organization_date', 'desc');

            if ($search) {
                $query->whereHas('student', function ($q) use ($search) {
                    $q->whereRaw("CAST(id_no AS CHAR) LIKE ?", ["%{$search}%"])
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
                $query->orWhereHas('course', function ($q) use ($search) {
                    $q->where('course_name', 'like', "%{$search}%");
                });
                $query->orWhereHas('organizationType', function ($q) use ($search) {
                    $q->where('organization_name', 'like', "%{$search}%");
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
                        'id_no' => $row->student ? $row->student->id_no : 'N/A',
                        'name' => $row->student ? $row->student->last_name . ', ' . $row->student->first_name : 'N/A',
                        'course_name' => $row->course ? $row->course->course_name : 'N/A',
                        'year_name' => $row->year ? $row->year->year_name : 'N/A',
                        'semester_name' => $row->semester ? $row->semester->semester_name : 'N/A',
                        'school_year_name' => $row->school_year ? $row->school_year->school_year_name : 'N/A',
                        'organization_name' => $row->organizationType ? $row->organizationType->organization_name : 'N/A',
                        'position_name' => $row->position ? $row->position->positions_name : 'N/A',
                        'organization_date' => $row->organization_date,

                    ];
                }),
            ]);
        }

        return view('admin.student-organization.display');
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
