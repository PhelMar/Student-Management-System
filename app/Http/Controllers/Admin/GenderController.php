<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    public function display()
    {
        $genders = Gender::all();
        return view('admin.features.gender.display', compact('genders'));
    }

    public function store(Request $request)
    {

        $validateData = $request->validate([
            'gender_name' => 'required|max:30',
        ]);
        Gender::create($validateData);
        return redirect()->route('admin.gender.display')->with('success', 'Data save successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'gender_name' => 'required|max:30',
        ]);

        $gender = Gender::findOrFail($id);
        $gender->gender_name = $request->gender_name;
        $gender->save();

        return redirect()->route('admin.gender.display')->with('success', 'Data change successfully!');
    }

    public function delete($id)
    {

        $gender = Gender::findOrFail($id);
        if ($gender) {
            $gender->delete();

            return response()->json(['success' => true, 'message' => 'Delete data successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Gender type not found.']);
    }
}
