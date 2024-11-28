<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationType;
use Illuminate\Http\Request;

class OrganizationTypeController extends Controller
{
    public function display(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search.value', '');

            $query = OrganizationType::query()->orderBy('created_at', 'desc');

            if ($search) {
                $query->where('organization_name', 'like', "%{$search}%");
            }

            $totalData = $query->count();
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($organization_types, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'organization_types_name' => $organization_types->organization_name,
                        'actions' => view('admin.features.organization-type.partials.actions', compact('organization_types'))->render(),
                    ];
                }),
            ]);
        }

        return view('admin.features.organization-type.display');
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

    public function delete($id)
    {

        $organizationType = OrganizationType::findOrFail($id);
        if ($organizationType) {
            $organizationType->delete();
            return response()->json(['success' => true, 'message' => 'Data has been deleted succesfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Data not Found!']);
    }
}
