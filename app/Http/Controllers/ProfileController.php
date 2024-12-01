<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit($hashId)
    {
        try {

            $id = Hashids::decode($hashId)[0] ?? null;

            if (!$id) {
                throw new Exception('Invalid ID');
            }

            $user = User::findOrFail($id);
            return view('profile.edit', compact('user'));
        } catch (Exception $e) {
            return redirect()->route('admin.profile.display')->with('error', 'Invalid input' . $e->getMessage());
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, $hashId)
    {
        try {
            $id = Hashids::decode($hashId)[0] ?? null;
            if (!$id) {
                throw new Exception('Invalid ID');
            }
            $user = User::findOrFail($id);

            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#?&]/',
                    'confirmed',
                ],
            ]);

            $queryValidation = $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if ($queryValidation) {
                return redirect()->route('admin.profile.display')->with('success', 'User updated successfully.');
            } else {
                return redirect()->route('admin.profile.display')->with('error', 'Please fill up correctly.');
            }
        } catch (Exception $e) {
            return redirect()->route('admin.profile.display')->with('error', 'Failed to updated.' . $e->getMessage());
        }
    }



    /**
     * Delete the user's account.
     */
    public function destroy($id)
    {

        $profileData = User::find($id);

        if ($profileData) {
            $profileData->delete();
            return response()->json(['success' => true, 'message' => 'Pofile data has been deleted!']);
        }
        return response()->json(['success' => false, 'message' => 'Profile not found!']);
    }

    public function display(Request $request)
    {

        if ($request->ajax()) {
            $query = User::select(['id', 'name', 'role', 'created_at', 'updated_at']);

            $totalData = $query->count();

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $search = $request->input('search.value', '');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%");
                });
            }

            $filteredData = $query->count();
            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $filteredData,
                'data' => $data->map(function ($row, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'name' => $row->name,
                        'role' => $row->role,
                        'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
                        'action' => '
                            <a href="' . route('admin.profile.edit', Hashids::encode([$row->id])) . '" class="btn btn-warning">Edit</a>
                            <a href="javascript:void(0)" onclick="confirmDelete(' . $row->id . ')" class="btn btn-danger">Delete</a>
                        ',
                    ];
                }),
            ]);
        }

        return view('profile.display');
    }

    public function validateCurrentPassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
        ]);

        $user = Auth::user(); // Auth already validated through middleware

        if (Hash::check($request->current_password, $user->password)) {
            return response()->json(['valid' => true]);
        }

        return response()->json(['valid' => false]);
    }
}
