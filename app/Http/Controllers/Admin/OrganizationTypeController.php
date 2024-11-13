<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationType;
use Illuminate\Http\Request;

class OrganizationTypeController extends Controller
{
    public function display()
    {

        $organization_types = OrganizationType::all();

        return view('admin.features.organization-type.display', compact('organization_types'));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'organization_name' => 'required|max:50',
        ]);
        OrganizationType::create($validateData);
        return redirect()->route('admin.organization_type.display')->with('success', 'Data has been added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'organization_name' => 'required|max:50',
        ]);

        $organizatioType = OrganizationType::findOrFail($id);
        $organizatioType->organization_name = $request->organization_name;
        $organizatioType->save();

        return redirect()->route('admin.organization_type.display')->with('success', 'Data has been updated successfully!');
    }

    public function delete($id){

        $organizationType = OrganizationType::findOrFail($id);
        if($organizationType){
            $organizationType->delete();
            return response()->json(['success' => true, 'message' => 'Data has been deleted succesfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not Found!']);
    }
}
