<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('login')->with('status', 'Your email is already verified.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        
            Auth::login($request->user());
        
            session()->regenerate();
        
            return redirect()->route('user.dashboard')->with('status', 'Your email has been successfully verified.');
        }        

        return redirect()->route('login')->with('error', 'Email verification failed. Please try again.');
    }
}
