<x-guest-layout>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="form-label fw-bold">{{ __('Name') }}</label>
                <input id="name" type="text"
                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name') }}"
                    placeholder="Enter your full name"
                    required autofocus autocomplete="name">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="form-label fw-bold">{{ __('Email') }}</label>
                <input id="email" type="email"
                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}"
                    placeholder="Enter your email address"
                    required autocomplete="username">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="form-label fw-bold">{{ __('Password') }}</label>
                <input id="password" type="password"
                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                    name="password" placeholder="Enter a secure password"
                    required autocomplete="new-password">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-bold">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" type="password"
                    class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                    name="password_confirmation" placeholder="Confirm your password"
                    required autocomplete="new-password">
                @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success btn-lg">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
    <div class="card-footer text-center text-muted small">
        <p>Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Log in</a></p>
    </div>
</x-guest-layout>