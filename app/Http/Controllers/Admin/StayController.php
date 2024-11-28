<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stay;
use Illuminate\Http\Request;

class StayController extends Controller
{
    public function display(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = Stay::query()->orderBy('created_at', 'desc');

            if ($search) {
                $query->where('stay_name', 'like', "%{$search}%");
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($stay, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'stay_name' => $stay->stay_name,
                        'actions' => view('admin.features.student-stay.partials.actions', compact('stay'))->render(),
                    ];
                }),
            ]);
        }

        return view('admin.features.student-stay.display');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stay_name' => 'required|max:100',
        ]);
        $stays = Stay::findOrFail($id);
        $stays->stay_name = $request->stay_name;
        $stays->save();
        return redirect()->route('admin.stay.display')->with('success', 'Data has been updated successfully!');
    }

    public function store(Request $request)
    {

        $validateData = $request->validate([
            'stay_name' => 'required|max:100',
        ]);
        Stay::create($validateData);
        return redirect()->route('admin.stay.display')->with('success', 'Data has been added successfully!');
    }

    public function delete($id)
    {
        $stays = Stay::findOrFail($id);
        if ($stays) {
            $stays->delete();
            return response()->json(['success' => true, 'message' => 'Data has been deleted successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not Found!']);
    }
}
