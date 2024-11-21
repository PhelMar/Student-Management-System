<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, $id)
    {
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
            'role' => ['required', 'in:admin,user'],
        ]);

        $queryValidation = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($queryValidation) {
            return redirect()->route('admin.profile.display')->with('success', 'User updated successfully.');
        } else {
            return redirect()->route('admin.profile.display')->with('error', 'Please fill up correctly.');
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

    public function display()
    {

        $profileData = User::orderBy('created_at', 'asc')
            ->get();

        return view('profile.display', compact('profileData'));
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
