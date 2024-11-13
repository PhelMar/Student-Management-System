<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Religion;
use Illuminate\Http\Request;

class ReligionController extends Controller
{
    public function display(){
        $religions = Religion::all();
        return view('admin.features.religion.display', compact('religions'));
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'religion_name' => 'required|max:100',
        ]);
        $religion = Religion::create($validateData);
        if($religion){
            return redirect()->route('admin.religion.display')->with('success','Data has been added successfully!');
        }
    }

    public function update(Request $request, $id){
        $request->validate([
            'religion_name' => 'required|max:100'
        ]);
        $religion = Religion::findOrFail($id);
        $religion->religion_name = $request->religion_name;
        $religion->save();
        return redirect()->route('admin.religion.display')->with('success','Data has been updated successfully!');
    }

    public function delete($id){
        $religion = Religion::findOrFail($id);
        if($religion){
            $religion->delete();
            return response()->json(['success' => true, 'message' => 'Data has been deleted successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not Found!']);
    }
}
