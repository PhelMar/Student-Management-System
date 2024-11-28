<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dialect;
use Illuminate\Http\Request;

class DialectController extends Controller
{
    public function display(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = Dialect::query()->orderBy('created_at', 'desc');

            if ($search) {
                $query->where('dialect_name', 'like', "%{$search}%");
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($dialect, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'dialect_name' => $dialect->dialect_name,
                        'actions' => view('admin.features.dialogue.partials.actions', compact('dialect'))->render(),
                    ];
                }),
            ]);
        }

        return view('admin.features.dialogue.display');
    }


    public function store(Request $request)
    {
        $validateData = $request->validate([
            'dialect_name' => 'required|max:100',
        ]);
        $dialect = Dialect::create($validateData);
        if ($dialect) {
            return redirect()->route('admin.dialect.display')->with('success', 'Data has been added successfully!');
        } else {
            return redirect()->route('admin.dialect.display')->with('error', 'Error at adding dialect');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dialect_name' => 'required|max:100',
        ]);
        $dialect = Dialect::find($id);
        if ($dialect) {
            $dialect->dialect_name = $request->dialect_name;
            $dialect->save();
            return redirect()->route('admin.dialect.display')->with('success', 'Data has been updated successfully!');
        } else {
            return redirect()->route('admin.dialect.display')->with('error', 'Data not Found!');
        }
    }

    public function delete($id)
    {
        $dialect = Dialect::findOrFail($id);
        if ($dialect) {
            $dialect->delete();
            return response()->json(['success' => true, 'message' => 'Data has been deleted successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not Found!']);
    }
}
