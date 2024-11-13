<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stay;
use Illuminate\Http\Request;

class StayController extends Controller
{
    public function display(){
        $stays = Stay::all();
        return view('admin.features.student-stay.display', compact('stays'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'stay_name' => 'required|max:100',
        ]);
        $stays = Stay::findOrFail($id);
        $stays->stay_name = $request->stay_name;
        $stays->save();
        return redirect()->route('admin.stay.display')->with('success', 'Data has been updated successfully!');
    }

    public function store(Request $request){

        $validateData = $request->validate([
            'stay_name' => 'required|max:100',
        ]);
        Stay::create($validateData);
        return redirect()->route('admin.stay.display')->with('success','Data has been added successfully!');
    }

    public function delete($id){
        $stays = Stay::findOrFail($id);
        if ($stays){
            $stays->delete();
            return response()->json(['success' => true, 'message' => 'Data has been deleted successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not Found!']);
    }
}
