@extends('layouts.app')

@section('content')
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card login-card">
                        <div class="card-header login-header text-center py-4">
                            <h3><i class="fas fa-user-plus me-2"></i>Create Account</h3>
                        </div>
                        <div class="card-body p-4">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ url('/register') }}" method="POST" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name <span style="color: red;">*</span></label>
                                        <div class="name-error text-danger mb-1" style="display:none; font-size:13px;">
                                            Special characters and numbers are not allowed.
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Enter your name" required>
                                        </div>
                                    </div>


                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Address <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Enter your email" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password <span style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Create a password" required>
                                        <button class="btn btn-outline-secondary toggle-btn" type="button"
                                            id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password <span style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control" placeholder="Confirm your password" required>
                                        <button class="btn btn-outline-secondary toggle-btn" type="button"
                                            id="togglePasswordConfirmation">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="role_id" class="form-label">Select Role <span
                                            style="color: red;">*</span></label>
                                    <select name="role_id" id="role_id" class="form-select" required>
                                        <option value="">-- Select Your Role --</option>
                                        @foreach ($roles as $role)
                                            @if ($role->name === 'Admin' || $role->name === 'admin')
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-user-plus me-2"></i> Create Account
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-3">
                                <p class="mb-0">Already have an account?
                                    <a href="{{ url('/login') }}" class="text-decoration-none">Login here</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            min-height: 100vh;
        }

        .login-container {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }

        .input-group-text {
            background-color: #fff;
            border-right: none;
        }

        .form-control {
            border-left: none;
        }

        .btn-outline-secondary.toggle-btn {
            background-color: #fff;
            border-left: none;
            color: #5a5a5a;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            padding: 0 16px;
            /* more spacing for better visibility */
        }

        .btn-outline-secondary.toggle-btn:hover {
            background-color: #f0f0f0;
            color: #5c3d99;
            transform: scale(1.05);
            border-color: #c2c2c2;
        }

        .btn-outline-secondary.toggle-btn i {
            font-size: 1.2rem;
            transition: transform 0.25s ease, color 0.25s ease;
        }

        .btn-outline-secondary.toggle-btn:hover i {
            transform: scale(1.2);
            color: #5c3d99;
        }

        .input-group .form-control:focus {
            box-shadow: none;
            border-color: #80bdff;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $('input[required], select[required]').each(function() {
                $(this).css('border', '2px solid red');
            });

            $('input[required], select[required]').on('input change', function() {
                if ($(this).val().trim() !== '') {
                    $(this).css('border', '');
                } else {
                    $(this).css('border', '2px solid red');
                }
            });

            $('form').on('submit', function(e) {
                let valid = true;
                const nameField = $('input[name="name"]');
                const regex = /^[A-Za-z\s]+$/;

                $('.name-error').hide();

                if (!regex.test(nameField.val().trim())) {
                    e.preventDefault();
                    nameField.css('border', '2px solid red');
                    nameField.closest('.mb-3').find('.name-error').show();
                    valid = false;
                }

                $('input[required], select[required]').each(function() {
                    if ($(this).val().trim() === '') {
                        $(this).css('border', '2px solid red');
                        if (valid) $(this).focus();
                        valid = false;
                    } else {
                        $(this).css('border', '');
                    }
                });

                if (!valid) e.preventDefault();
            });


            $('form').on('submit', function(e) {
                let valid = true;
                const nameField = $('input[name="name"]');
                const regex = /^[A-Za-z\s]+$/;

                if (!regex.test(nameField.val().trim())) {
                    e.preventDefault();
                    nameField.css('border', '2px solid red');
                    nameField.closest('.mb-3').find('.name-error').show();
                    valid = false;
                }

                $('input[required], select[required]').each(function() {
                    if ($(this).val().trim() === '') {
                        $(this).css('border', '2px solid red');
                        if (valid) $(this).focus();
                        valid = false;
                    }
                });

                if (!valid) e.preventDefault();
            });

            $('#togglePassword, #togglePasswordConfirmation').on('click', function() {
                const input = $(this).siblings('input');
                const type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            });
        });
    </script>
