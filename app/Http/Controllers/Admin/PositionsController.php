<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionsController extends Controller
{
    public function display(){
        $positions = Position::all();
        return view('admin.features.student-position.display', compact('positions'));
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'positions_name' => 'required|max:100',
        ]);
        Position::create($validateData);
        return redirect()->route('admin.position.display')->with('success', 'Data has been added successfully!');
    }

    public function update(Request $request, $id){
        $request->validate([
            'positions_name' => 'required|max:100',
        ]);
        $position = Position::findOrFail($id);
        $position->positions_name = $request->positions_name;
        $position->save();
        return redirect()->route('admin.position.display')->with('success','Data has been updated successfully!');
    }

    public function delete($id){
        $position = Position::findOrFail($id);
        if($position){
            $position->delete();
            return response()->json(['success' => true, 'message' => 'Data has been deleted succesfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not Found']);
    }
}
