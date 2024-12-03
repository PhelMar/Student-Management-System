<x-guest-layout>
    <div class="card-header text-center text-white" style="background-color: #0A7075;">
        <h5 class="mb-0">{{ __('Log In') }}</h5>
    </div>
    <div class="card-body p-4">
        <!-- Session Status -->
        @if (session('status'))
        <div class="alert alert-success mb-4">
            {{ session('status') }}
        </div>
        @endif

        <!-- Error Message Placeholder -->
        <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>

        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                <div class="invalid-feedback"></div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label fw-bold">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">
                <div class="invalid-feedback"></div>
            </div>

            <!-- Remember Me -->
            <div class="form-check mb-3">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
            </div>

            <!-- Submit Button and Forgot Password Link -->
            <div class="d-flex justify-content-between align-items-center">
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none">
                    {{ __('Forgot your password?') }}
                </a>
                @endif
                <button type="submit" class="btn btn-primary">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                const formData = {
                    email: $('#email').val(),
                    password: $('#password').val(),
                    remember: $('#remember_me').is(':checked') ? 'on' : 'off'
                };

                $.ajax({
                    url: "{{ route('login') }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            $('#errorMessage').text('Unexpected response. Please try again.').show();
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON?.errors || {};
                        if (errors.email) {
                            $('#email').addClass('is-invalid').siblings('.invalid-feedback').text(errors.email[0]);
                        }
                        if (errors.password) {
                            $('#password').addClass('is-invalid').siblings('.invalid-feedback').text(errors.password[0]);
                        }
                        if (!errors.email && !errors.password) {
                            $('#errorMessage').text(xhr.responseJSON?.message || 'An error occurred.').show();
                        }
                    }
                });
            });
        });
    </script>
</x-guest-layout>