<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ViolationsType;
use Illuminate\Http\Request;

class ViolationsController extends Controller
{
    public function display(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = ViolationsType::query()->orderBy('created_at', 'desc');

            if ($search) {
                $query->where('violation_type_name', 'like', "%{$search}%");
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($violation_type, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'violation_type_name' => $violation_type->violation_type_name,
                        'actions' => view('admin.features.violations-type.partials.actions', compact('violation_type'))->render(),
                    ];
                }),
            ]);
        }

        return view('admin.features.violations-type.display');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'violation_type_name' => 'required|max:200',
        ]);
        $violations = ViolationsType::create($validateData);
        if ($violations) {
            return redirect()->route('admin.violation_type.display')->with('success', 'Data has been added successfully!');
        } else {
            return redirect()->route('admin.violation_type.display')->with('error', 'Error at adding violations type!');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'violation_type_name' => 'required|max:200'
        ]);
        $violations = ViolationsType::find($id);
        if ($violations) {
            $violations->violation_type_name = $request->violation_type_name;
            $violations->save();
            return redirect()->route('admin.violation_type.display')->with('success', 'Data has been updated successfully!');
        } else {
            return redirect()->route('admin.violation_type.display')->with('error', 'Data not Found!');
        }
    }

    public function delete($id)
    {
        $violations = ViolationsType::find($id);
        if ($violations) {
            $violations->delete();
            return response()->json(['success' => true, 'message' => 'Data has bee deleted successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data not found!']);
        }
    }
}
