@extends('layouts.homepage')

@section('title', 'Sign In - Laravel Clinic')

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
            background-color: ##318C7E;
            border-color: ##318C7E;
        }

        .card-header {
            background-color: ##318C7E !important;
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-white">
                        <h4 class="mb-0" style="color: #318C7E">Patient Sign In</h4>
                    </div>
                    <div class="card-body">
                        {{-- Add this after the card-header --}}
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

                        {{-- Show only the first error for invalid credentials --}}
                        @if ($errors->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show m-3">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{-- Show other validation errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        @if ($error !== $errors->first('error'))
                                            <li>{{ $error }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('patient.signin.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>
                            <button type="submit" class="btn btn w-100" style="background-color:#318C7E ">Sign In</button>
                        </form>
                        <div class="text-center mt-3">
                            <p>Don't have an account? <a href="{{ route('patient.signup') }}">Sign Up</a></p>
                            <p><a href="{{ route('patient.forgot.password.form') }}">Forgot Password?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


@endsection
