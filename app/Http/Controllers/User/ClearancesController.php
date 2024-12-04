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
use Illuminate\Validation\Rule;

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

    public function display(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);

        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = Clearance::with([
                'course:id,course_name',
                'year:id,year_name',
                'semester:id,semester_name',
                'school_year:id,school_year_name',
                'student:id,id_no,last_name,first_name',
            ])
                ->orderBy('created_at', 'desc');

            if ($search) {
                $query->whereHas('student', function ($q) use ($search) {
                    $q->whereRaw("CAST(id_no AS CHAR) LIKE ?", ["%{$search}%"])
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('control_no', 'like', "%{$search}%");
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
                'data' => $data->map(function ($clearance, $index) use ($start) {
                    return [
                        'id' => $clearance->id,
                        'DT_RowIndex' => $start + $index + 1,
                        'control_no' => $clearance->control_no,
                        'student_name' => $clearance->student ? $clearance->student->last_name . ', ' . $clearance->student->first_name : 'N/A',
                        'course_name' => $clearance->course->course_name ?? 'N/A',
                        'year_name' => $clearance->year->year_name ?? 'N/A',
                        'semester_name' => $clearance->semester->semester_name ?? 'N/A',
                        'school_year_name' => $clearance->school_year->school_year_name ?? 'N/A',
                        'status' => $clearance->status,
                        'created_at' => $clearance->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $clearance->updated_at->format('Y-m-d H:i:s'),
                    ];
                }),
            ]);
        }

        return view('users.student-clearance.display');
    }


    public function clearedStudentDisplay()
    {
        return view('users.student-clearance.clearedClearance');
    }

    public function BSITcleared(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);

        if ($request->ajax()) {

            $query = Clearance::whereHas('course', function ($q) {
                $q->where('course_name', 'BSIT');
            })
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                    'student:id,id_no,last_name,first_name',
                ])
                ->where('status', 'cleared')
                ->orderBy('created_at', 'desc');

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
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'student_name' => "{$row->student->last_name}, {$row->student->first_name}",
                        'course_name' => $row->course->course_name ?? 'N/A',
                        'year_name' => $row->year->year_name ?? 'N/A',
                        'school_year_name' => $row->school_year->school_year_name ?? 'N/A',
                        'status' => $row->status,
                    ];
                }),
            ]);
        }

        return view('users.student-clearance.clearedClearance');
    }

    public function BSTMcleared(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);

        if ($request->ajax()) {

            $query = Clearance::whereHas('course', function ($q) {
                $q->where('course_name', 'BSTM');
            })
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                    'student:id,id_no,last_name,first_name',
                ])
                ->where('status', 'cleared')
                ->orderBy('created_at', 'desc');

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
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'student_name' => "{$row->student->last_name}, {$row->student->first_name}",
                        'course_name' => $row->course->course_name ?? 'N/A',
                        'year_name' => $row->year->year_name ?? 'N/A',
                        'school_year_name' => $row->school_year->school_year_name ?? 'N/A',
                        'status' => $row->status,
                    ];
                }),
            ]);
        }

        return view('users.student-clearance.clearedClearance');
    }

    public function BSBAFMcleared(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);
        if ($request->ajax()) {

            $query = Clearance::whereHas('course', function ($q) {
                $q->where('course_name', 'BSBA FM');
            })
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                    'student:id,id_no,last_name,first_name',
                ])
                ->where('status', 'cleared')
                ->orderBy('created_at', 'desc');

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
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'student_name' => "{$row->student->last_name}, {$row->student->first_name}",
                        'course_name' => $row->course->course_name ?? 'N/A',
                        'year_name' => $row->year->year_name ?? 'N/A',
                        'school_year_name' => $row->school_year->school_year_name ?? 'N/A',
                        'status' => $row->status,
                    ];
                }),
            ]);
        }

        return view('users.student-clearance.clearedClearance');
    }

    public function BSBAMMcleared(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);
        if ($request->ajax()) {

            $query = Clearance::whereHas('course', function ($q) {
                $q->where('course_name', 'BSBA MM');
            })
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                    'student:id,id_no,last_name,first_name',
                ])
                ->where('status', 'cleared')
                ->orderBy('created_at', 'desc');

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
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'student_name' => "{$row->student->last_name}, {$row->student->first_name}",
                        'course_name' => $row->course->course_name ?? 'N/A',
                        'year_name' => $row->year->year_name ?? 'N/A',
                        'school_year_name' => $row->school_year->school_year_name ?? 'N/A',
                        'status' => $row->status,
                    ];
                }),
            ]);
        }

        return view('users.student-clearance.clearedClearance');
    }

    public function BEEDcleared(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);
        if ($request->ajax()) {

            $query = Clearance::whereHas('course', function ($q) {
                $q->where('course_name', 'BEED');
            })
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                    'student:id,id_no,last_name,first_name',
                ])
                ->where('status', 'cleared')
                ->orderBy('created_at', 'desc');

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
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'student_name' => "{$row->student->last_name}, {$row->student->first_name}",
                        'course_name' => $row->course->course_name ?? 'N/A',
                        'year_name' => $row->year->year_name ?? 'N/A',
                        'school_year_name' => $row->school_year->school_year_name ?? 'N/A',
                        'status' => $row->status,
                    ];
                }),
            ]);
        }

        return view('users.student-clearance.clearedClearance');
    }

    public function BSEDSOCIALSTUDIEScleared(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);
        if ($request->ajax()) {

            $query = Clearance::whereHas('course', function ($q) {
                $q->where('course_name', 'BSED SOCIAL STUDIES');
            })
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                    'student:id,id_no,last_name,first_name',
                ])
                ->where('status', 'cleared')
                ->orderBy('created_at', 'desc');

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
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'student_name' => "{$row->student->last_name}, {$row->student->first_name}",
                        'course_name' => $row->course->course_name ?? 'N/A',
                        'year_name' => $row->year->year_name ?? 'N/A',
                        'school_year_name' => $row->school_year->school_year_name ?? 'N/A',
                        'status' => $row->status,
                    ];
                }),
            ]);
        }

        return view('users.student-clearance.clearedClearance');
    }

    public function BSEDENGLISHcleared(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);
        if ($request->ajax()) {

            $query = Clearance::whereHas('course', function ($q) {
                $q->where('course_name', 'BSED ENGLISH');
            })
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                    'student:id,id_no,last_name,first_name',
                ])
                ->where('status', 'cleared')
                ->orderBy('created_at', 'desc');

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
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'student_name' => "{$row->student->last_name}, {$row->student->first_name}",
                        'course_name' => $row->course->course_name ?? 'N/A',
                        'year_name' => $row->year->year_name ?? 'N/A',
                        'school_year_name' => $row->school_year->school_year_name ?? 'N/A',
                        'status' => $row->status,
                    ];
                }),
            ]);
        }

        return view('users.student-clearance.clearedClearance');
    }

    public function BSEDVALUEScleared(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);
        if ($request->ajax()) {

            $query = Clearance::whereHas('course', function ($q) {
                $q->where('course_name', 'BSED VALUES');
            })
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                    'student:id,id_no,last_name,first_name',
                ])
                ->where('status', 'cleared')
                ->orderBy('created_at', 'desc');

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
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'student_name' => "{$row->student->last_name}, {$row->student->first_name}",
                        'course_name' => $row->course->course_name ?? 'N/A',
                        'year_name' => $row->year->year_name ?? 'N/A',
                        'school_year_name' => $row->school_year->school_year_name ?? 'N/A',
                        'status' => $row->status,
                    ];
                }),
            ]);
        }

        return view('users.student-clearance.clearedClearance');
    }

    public function BSCRIMcleared(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);
        if ($request->ajax()) {

            $query = Clearance::whereHas('course', function ($q) {
                $q->where('course_name', 'BSCRIM');
            })
                ->with([
                    'course:id,course_name',
                    'year:id,year_name',
                    'semester:id,semester_name',
                    'school_year:id,school_year_name',
                    'student:id,id_no,last_name,first_name',
                ])
                ->where('status', 'cleared')
                ->orderBy('created_at', 'desc');

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
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'student_name' => "{$row->student->last_name}, {$row->student->first_name}",
                        'course_name' => $row->course->course_name ?? 'N/A',
                        'year_name' => $row->year->year_name ?? 'N/A',
                        'school_year_name' => $row->school_year->school_year_name ?? 'N/A',
                        'status' => $row->status,
                    ];
                }),
            ]);
        }

        return view('users.student-clearance.clearedClearance');
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

    public function bsitClearedPrint()
    {
        $BSIT = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSIT');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        return view('users.student-clearance.bsit-print', compact('BSIT'));
    }

    public function bsbammClearedPrint()
    {
        $BSBA_MM = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSBA MM');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        return view('users.student-clearance.bsba-mm-print', compact('BSBA_MM'));
    }

    public function bstmClearedPrint()
    {
        $BSTM = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSTM');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        return view('users.student-clearance.bstm-print', compact('BSTM'));
    }

    public function bsbafmClearedPrint()
    {
        $BSBA_FM = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSBA FM');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        return view('users.student-clearance.bsba-fm-print', compact('BSBA_FM'));
    }

    public function beedClearedPrint()
    {
        $BEED = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BEED');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        return view('users.student-clearance.beed-print', compact('BEED'));
    }

    public function bsedvaluesClearedPrint()
    {
        $BSED_VALUES = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSED VALUES');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        return view('users.student-clearance.bsed-values-print', compact('BSED_VALUES'));
    }

    public function bsedsocialstudiesClearedPrint()
    {
        $BSED_SOCIAL_STUDIES = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSED SOCIAL STUDIES');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        return view('users.student-clearance.bsed-social-studies-print', compact('BSED_SOCIAL_STUDIES'));
    }
    public function bsedenglishClearedPrint()
    {
        $BSED_ENGLISH = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSED ENGLISH');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        return view('users.student-clearance.bsed-english-print', compact('BSED_ENGLISH'));
    }
    public function bscrimClearedPrint()
    {
        $BSCRIM = Clearance::whereHas('course', function ($query) {
            $query->where('course_name', 'BSCRIM');
        })
            ->with(['course', 'year', 'semester', 'school_year', 'student'])
            ->where('status', 'cleared')
            ->orderBy(Student::select('last_name')->whereColumn('tbl_students.id', 'tbl_clearances.student_id'), 'asc')
            ->get();

        return view('users.student-clearance.bscrim-print', compact('BSCRIM'));
    }
}
