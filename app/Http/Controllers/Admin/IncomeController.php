<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function display()
    {
        $incomes = Income::all();
        return view('admin.features.income.display', compact('incomes'));
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
