<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        Log::info('Verifying email for user: ' . $request->user()->email);

        if ($request->user()->hasVerifiedEmail()) {
            Log::info('Email already verified.');
            return redirect()->route('user.dashboard');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
            Log::info('Email successfully verified for user: ' . $request->user()->email);
            Auth::login($request->user());
        } else {
            Log::error('Email verification failed for user: ' . $request->user()->email);
        }

        return redirect()->route('user.dashboard');
    }
}
