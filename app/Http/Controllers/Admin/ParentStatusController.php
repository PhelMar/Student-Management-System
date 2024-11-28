<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentStatuses;
use Illuminate\Http\Request;

class ParentStatusController extends Controller
{
    public function display(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = ParentStatuses::query()->orderBy('created_at', 'desc');

            if ($search) {
                $query->where('status', 'like', "%{$search}%");
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($parent_status, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'parent_status_name' => $parent_status->status,
                        'actions' => view('admin.features.parent-status.partials.actions', compact('parent_status'))->render(),
                    ];
                }),
            ]);
        }

        return view('admin.features.parent-status.display');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'status' => 'required|max:100',
        ]);
        $parent_status = ParentStatuses::create($validateData);
        if ($parent_status) {
            return redirect()->route('admin.parent_status.display')->with('success', 'Data has been added succesfully!');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|max:100',
        ]);
        $parent_status = ParentStatuses::findOrFail($id);
        $parent_status->status = $request->status;
        $parent_status->save();
        return redirect()->route('admin.parent_status.display')->with('success', 'Data has been updated successfully!');
    }

    public function delete($id)
    {
        $parent_status = ParentStatuses::findOrFail($id);
        if ($parent_status) {
            $parent_status->delete();
            return response()->json(['success' => true, 'message' => 'Data has been delete successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not Found']);
    }
}
