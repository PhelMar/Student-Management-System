<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function display()
    {
        $courses = Course::all();
        return view('admin.features.course.display', compact('courses'));
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
