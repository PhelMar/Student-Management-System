<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse|RedirectResponse
    {
        try {
            $request->authenticate();
            
            $request->session()->regenerate();

            if (!$request->user()->hasVerifiedEmail()) {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return response()->json(['error' => 'Please verify your email address before logging in.'], 403);
            }

            $redirectUrl = match ($request->user()->role) {
                'admin' => route('admin.dashboard'),
                'user' => route('user.dashboard'),
                'guard' => route('guard.violations.display'),
                default => route('home')
            };

            return response()->json(['redirect' => $redirectUrl]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid credentials. Please try again.'], 401);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
