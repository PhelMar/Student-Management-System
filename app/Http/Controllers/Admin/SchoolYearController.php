<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
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

            $query = SchoolYear::query()->orderBy('created_at', 'desc');

            if ($search) {
                $query->where('school_year_name', 'like', "%{$search}%");
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($school_year, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'school_year_name' => $school_year->school_year_name,
                        'actions' => view('admin.features.school-year.partials.actions', compact('school_year'))->render(),
                    ];
                }),
            ]);
        }

        return view('admin.features.school-year.display');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'school_year_name' => 'required|max:100',
        ]);
        $school_year = SchoolYear::create($validateData);
        if ($school_year) {
            return redirect()->route('admin.school_year.display')->with('success', 'Data has been added successfully!');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'school_year_name' => 'required|max:100',
        ]);
        $school_year = SchoolYear::findOrFail($id);
        $school_year->school_year_name = $request->school_year_name;
        $school_year->save();
        return redirect()->route('admin.school_year.display')->with('success', 'Data has been updated successfully!');
    }

    public function delete($id)
    {
        $school_year = SchoolYear::findOrFail($id);
        if ($school_year) {
            $school_year->delete();
            return response()->json(['success' => true, 'message' => 'Data has been deleted successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not found!']);
    }
}
