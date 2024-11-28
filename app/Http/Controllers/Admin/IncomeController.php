<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function display(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = Income::query()->orderBy('created_at', 'desc');

            if ($search) {
                $query->where('income_base', 'like', "%{$search}%");
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($income, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'income_name' => $income->income_base,
                        'actions' => view('admin.features.income.partials.actions', compact('income'))->render(),
                    ];
                }),
            ]);
        }

        return view('admin.features.income.display');
    }

    public function store(Request $request)
    {

        $validateData = $request->validate([
            'income_base' => 'required|max:30',
        ]);
        Income::create($validateData);
        return redirect()->route('admin.income.display')->with('success', 'Data save successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'income_base' => 'required|max:30',
        ]);

        $income = Income::findOrFail($id);
        $income->income_base = $request->income_base;
        $income->save();

        return redirect()->route('admin.income.display')->with('success', 'Data change successfully!');
    }

    public function delete($id)
    {

        $income = Income::findOrFail($id);
        if ($income) {
            $income->delete();

            return response()->json(['success' => true, 'message' => 'Delete data successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'income type not found.']);
    }
}
