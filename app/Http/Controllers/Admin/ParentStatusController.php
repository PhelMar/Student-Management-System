<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentStatuses;
use Illuminate\Http\Request;

class ParentStatusController extends Controller
{
    public function display()
    {
        $parent_statuses = ParentStatuses::all();
        return view('admin.features.parent-status.display', compact('parent_statuses'));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'status' => 'required|max:100',
        ]);
        $parent_status = ParentStatuses::create($validateData);
        if ($parent_status) {
            return redirect()->route('admin.parent_status.display')->with('success', 'Data has been added succesfully!');
        }
    }

    public function update(Request $request, $id){
        $request->validate([
            'status' => 'required|max:100',
        ]);
        $parent_status = ParentStatuses::findOrFail($id);
        $parent_status->status = $request->status;
        $parent_status->save();
        return redirect()->route('admin.parent_status.display')->with('success','Data has been updated successfully!');
    }

    public function delete($id){
        $parent_status = ParentStatuses::findOrFail($id);
        if ($parent_status){
            $parent_status->delete();
            return response()->json(['success' => true, 'message' => 'Data has been delete successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not Found']);
    }
}
