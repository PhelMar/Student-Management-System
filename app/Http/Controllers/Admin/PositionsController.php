<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionsController extends Controller
{
    public function display(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = Position::query()->orderBy('created_at', 'desc');

            if ($search) {
                $query->where('positions_name', 'like', "%{$search}%");
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($position, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'position_name' => $position->positions_name,
                        'actions' => view('admin.features.student-position.partials.actions', compact('position'))->render(),
                    ];
                }),
            ]);
        }

        return view('admin.features.student-position.display');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'positions_name' => 'required|max:100',
        ]);
        Position::create($validateData);
        return redirect()->route('admin.position.display')->with('success', 'Data has been added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'positions_name' => 'required|max:100',
        ]);
        $position = Position::findOrFail($id);
        $position->positions_name = $request->positions_name;
        $position->save();
        return redirect()->route('admin.position.display')->with('success', 'Data has been updated successfully!');
    }

    public function delete($id)
    {
        $position = Position::findOrFail($id);
        if ($position) {
            $position->delete();
            return response()->json(['success' => true, 'message' => 'Data has been deleted succesfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not Found']);
    }
}
