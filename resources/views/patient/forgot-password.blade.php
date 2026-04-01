@extends('layouts.homepage')

@section('title', 'Forgot Password - Laravel Clinic')

@section('content')
    <style>   body {
    background-image: url('https://img.freepik.com/free-photo/young-handsome-physician-medical-robe-with-stethoscope_1303-17818.jpg?t=st=1746139347~exp=1746142947~hmac=c73e58a65605a23c92ca600973692cc8372440233a35d7e4552b6ae9d820da4c&w=1060');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    background-repeat: no-repeat;
    /* No overlay - image full visible */
}

        .form-control:focus {
            border-color: #318C7E;
            box-shadow: 0 0 0 0.2rem rgba(32, 125, 54, 0.25);
        }

        .btn-primary {
            background-color: #318C7E;
            border-color: #318C7E;
        }

        .card-header {
            background-color: #318C7E !important;
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-white">
                        <h4 class="mb-0" style="color: #318C7E">Forgot Password</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show m-3">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show m-3">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('patient.forgot.password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="6">
                                <div id="passwordMatchError" class="text-danger mt-1" style="display: none;">Passwords do not match.</div>
                            </div>
                            <button type="submit" class="btn btn w-100" style="background-color:#318C7E ">Send Reset Link</button>
                        </form>
                        <div class="text-center mt-3">
                            <p>Remember your password? <a href="{{ route('patient.signin') }}">Sign In</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('confirm_password').addEventListener('input', function() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = this.value;
            const errorDiv = document.getElementById('passwordMatchError');

            if (confirmPassword && newPassword !== confirmPassword) {
                errorDiv.style.display = 'block';
            } else {
                errorDiv.style.display = 'none';
            }
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (newPassword !== confirmPassword) {
                e.preventDefault();
                document.getElementById('passwordMatchError').style.display = 'block';
                return false;
            }
        });
    </script>
@endsection
