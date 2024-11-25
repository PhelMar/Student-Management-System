@extends('layouts.admin')
@section('title', 'Update User')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPasswordInput = document.getElementById('current_password');
        const feedback = document.getElementById('current_password_feedback');

        currentPasswordInput.addEventListener('input', function() {
            const password = currentPasswordInput.value;

            if (password === "") {
                feedback.textContent = ""; // Clear feedback if the field is empty
                feedback.classList.remove('text-danger', 'text-success');
                return;
            }

            fetch('{{ route("admin.validateCurrentPassword") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        current_password: password,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.valid) {
                        feedback.textContent = 'Password is correct.';
                        feedback.classList.add('text-success');
                        feedback.classList.remove('text-danger');
                    } else {
                        feedback.textContent = 'Password is incorrect.';
                        feedback.classList.add('text-danger');
                        feedback.classList.remove('text-success');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    feedback.textContent = 'An error occurred. Please try again.';
                    feedback.classList.add('text-danger');
                });
        });
    });
</script>
@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow" style="width: 400px;">
        <div class="card-header text-center text-white" style="background-color: #0A7075"><h5>Update Login Credentials</h5></div>
        <div class="card-body">
            <!-- Error and Success Alert Messages -->
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.profile.update', Hashids::encode($user->id)) }}" method="POST" id="updateForm">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" required>
                    <span id="current_password_feedback" class="form-text"></span>
                </div>


                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <span id="password-error" class="text-danger" style="display: none;">Password must be at least 8 characters, including a lowercase letter, an uppercase letter, a number, and a special character.</span>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    <span id="confirm-password-error" class="text-danger" style="display: none;">Passwords do not match.</span>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.profile.display') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add the JavaScript for real-time validation -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const currentPassword = document.getElementById('current_password');

        const passwordError = document.getElementById('password-error');
        const confirmPasswordError = document.getElementById('confirm-password-error');
        const currentPasswordError = document.getElementById('current-password-error');

        // Real-time password validation
        password.addEventListener('input', function() {
            const passwordValue = password.value;
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$/;
            if (!passwordRegex.test(passwordValue)) {
                passwordError.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
            }
        });

        // Real-time confirm password validation
        confirmPassword.addEventListener('input', function() {
            if (confirmPassword.value !== password.value) {
                confirmPasswordError.style.display = 'block';
            } else {
                confirmPasswordError.style.display = 'none';
            }
        });
    });
</script>
@endsection