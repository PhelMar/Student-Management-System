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
    public function edit(Request $request): View
    {
        // Check if the user is an admin
        if ($request->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Check if the user is an admin
        if ($request->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        // Check if the user is an admin
        if ($request->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Validate the password fields
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

        // Update the password
        $request->user()->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return Redirect::route('admin.profile.edit')->with('status', 'password-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy($id){

        $profileData = User::find($id);

        if($profileData){
            $profileData->delete();
            return response()->json(['success' => true, 'message' => 'Pofile data has been deleted!']);
        }
        return response()->json(['success'=> false,'message'=> 'Profile not found!']);
    }

    public function display()
    {

        $profileData = User::orderBy('created_at', 'asc')
            ->get();

        return view('profile.display', compact('profileData'));
    }
}
