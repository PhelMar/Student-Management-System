<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dialect;
use Illuminate\Http\Request;

class DialectController extends Controller
{
    public function display(){
        $dialects = Dialect::all();
        return view('admin.features.dialogue.display', compact('dialects'));
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'dialect_name' => 'required|max:100',
        ]);
        $dialect = Dialect::create($validateData);
        if($dialect){
            return redirect()->route('admin.dialect.display')->with('success', 'Data has been added successfully!');
        } else {
        return redirect()->route('admin.dialect.display')->with('error','Error at adding dialect');
        }
    }

    public function update(Request $request, $id){
        $request->validate([
            'dialect_name' => 'required|max:100',
        ]);
        $dialect = Dialect::find($id);
        if ($dialect){
            $dialect->dialect_name = $request->dialect_name;
            $dialect->save();
            return redirect()->route('admin.dialect.display')->with('success','Data has been updated successfully!');
        } else {
            return redirect()->route('admin.dialect.display')->with('error','Data not Found!');
        }
    }

    public function delete($id){
        $dialect = Dialect::findOrFail($id);
        if ($dialect){
            $dialect->delete();
            return response()->json(['success' => true, 'message' => 'Data has been deleted successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not Found!']);
    }
}
