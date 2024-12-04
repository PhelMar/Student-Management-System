<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function display(Request $request)
    {
        $request->validate([
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\s]*$/',
        ]);
        
        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = Course::query()->orderBy('created_at', 'desc');

            if ($search) {
                $query->where('course_name', 'like', "%{$search}%");
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($course, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'course_name' => $course->course_name,
                        'actions' => view('admin.features.course.partials.actions', compact('course'))->render(),
                    ];
                }),
            ]);
        }

        return view('admin.features.course.display');
    }


    public function store(Request $request)
    {

        $validateData = $request->validate([
            'course_name' => 'required|max:30',
        ]);
        Course::create($validateData);
        return redirect()->route('admin.course.display')->with('success', 'Data save successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'course_name' => 'required|max:30',
        ]);

        $course = Course::findOrFail($id);
        $course->course_name = $request->course_name;
        $course->save();

        return redirect()->route('admin.course.display')->with('success', 'Data change successfully!');
    }

    public function delete($id)
    {

        $course = Course::findOrFail($id);
        if ($course) {
            $course->delete();

            return response()->json(['success' => true, 'message' => 'Delete data successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'course type not found.']);
    }
}
