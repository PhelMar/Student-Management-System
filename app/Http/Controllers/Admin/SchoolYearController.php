<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    public function display(){
        $school_years = SchoolYear::all();
        return view('admin.features.school-year.display', compact('school_years'));
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'school_year_name' => 'required|max:100',
        ]);
        $school_year = SchoolYear::create($validateData);
        if ($school_year){
            return redirect()->route('admin.school_year.display')->with('success','Data has been added successfully!');
        }
    }

    public function update(Request $request, $id){
        $request->validate([
            'school_year_name' => 'required|max:100',
        ]);
        $school_year = SchoolYear::findOrFail($id);
        $school_year->school_year_name = $request->school_year_name;
        $school_year->save();
        return redirect()->route('admin.school_year.display')->with('success','Data has been updated successfully!');
    }

    public function delete($id){
        $school_year = SchoolYear::findOrFail($id);
        if($school_year){
            $school_year->delete();
            return response()->json(['success' => true, 'message' => 'Data has been deleted successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not found!']);
    }
}
