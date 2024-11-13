<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ViolationsType;
use Illuminate\Http\Request;

class ViolationsController extends Controller
{
    public function display(){
        $violation_types = ViolationsType::all();
        return view('admin.features.violations-type.display', compact('violation_types'));
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'violation_type_name' => 'required|max:200',
        ]);
        $violations = ViolationsType::create($validateData);
        if($violations){
            return redirect()->route('admin.violation_type.display')->with('success','Data has been added successfully!');

        } else {
            return redirect()->route('admin.violation_type.display')->with('error','Error at adding violations type!');
        }
    }

    public function update(Request $request, $id){
        $request->validate([
            'violation_type_name' => 'required|max:200'
        ]);
        $violations = ViolationsType::find($id);
        if($violations){
            $violations->violation_type_name = $request->violation_type_name;
            $violations->save();
            return redirect()->route('admin.violation_type.display')->with('success','Data has been updated successfully!');
        } else {
            return redirect()->route('admin.violation_type.display')->with('error','Data not Found!');
        }
    }

    public function delete($id){
        $violations = ViolationsType::find($id);
        if($violations){
            $violations->delete();
            return response()->json(['success' => true, 'message' => 'Data has bee deleted successfully!']);
        } else { 
            return response()->json(['success' => false, 'message' => 'Data not found!']);
        }
    }
}
