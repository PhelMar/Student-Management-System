<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Religion;
use Illuminate\Http\Request;

class ReligionController extends Controller
{
    public function display(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = Religion::query()->orderBy('created_at', 'desc');

            if ($search) {
                $query->where('religion_name', 'like', "%{$search}%");
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($religion, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'religion_name' => $religion->religion_name,
                        'actions' => view('admin.features.religion.partials.actions', compact('religion'))->render(),
                    ];
                }),
            ]);
        }

        return view('admin.features.religion.display');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'religion_name' => 'required|max:100',
        ]);
        $religion = Religion::create($validateData);
        if ($religion) {
            return redirect()->route('admin.religion.display')->with('success', 'Data has been added successfully!');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'religion_name' => 'required|max:100'
        ]);
        $religion = Religion::findOrFail($id);
        $religion->religion_name = $request->religion_name;
        $religion->save();
        return redirect()->route('admin.religion.display')->with('success', 'Data has been updated successfully!');
    }

    public function delete($id)
    {
        $religion = Religion::findOrFail($id);
        if ($religion) {
            $religion->delete();
            return response()->json(['success' => true, 'message' => 'Data has been deleted successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not Found!']);
    }
}
