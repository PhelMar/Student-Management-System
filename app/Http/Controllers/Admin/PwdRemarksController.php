<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PwdRemarks;
use Illuminate\Http\Request;

class PwdRemarksController extends Controller
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

            $query = PwdRemarks::query()->orderBy('created_at', 'desc');

            if ($search) {
                $query->where('pwd_name', 'like', "%{$search}%");
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($pwdRemarks, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'pwd_name' => $pwdRemarks->pwd_name,
                        'actions' => view('admin.features.pwd-remarks.partials.actions', compact('pwdRemarks'))->render(),
                    ];
                }),
            ]);
        }

        return view('admin.features.pwd-remarks.display');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'pwd_name' => 'required|max:100',
        ]);
        $pwdRemarks = PwdRemarks::create($validateData);
        if ($pwdRemarks) {
            return redirect()->route('admin.pwd-remarks.display')->with('success', 'Data has been added successfully!');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pwd_name' => 'required|max:100'
        ]);
        $pwdRemarks = PwdRemarks::findOrFail($id);
        $pwdRemarks->pwd_name = $request->pwd_name;
        $pwdRemarks->save();
        return redirect()->route('admin.pwd-remarks.display')->with('success', 'Data has been updated successfully!');
    }

    public function delete($id)
    {
        $pwdRemarks = PwdRemarks::findOrFail($id);
        if ($pwdRemarks) {
            $pwdRemarks->delete();
            return response()->json(['success' => true, 'message' => 'Data has been deleted successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not Found!']);
    }
}
