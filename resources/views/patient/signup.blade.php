@extends('layouts.homepage')

@section('title', 'Patient Sign Up')

@section('content')
    <style>
        :root {
            --primary-color: #3EA293;
            --primary-dark: #2D8577;
            --secondary-color: #FF6B6B;
            --text-dark: #2D3748;
            --text-light: #718096;
            --border-color: #E2E8F0;
            --background-light: #F7FAFC;
        }
        body {
    background-image: url('https://img.freepik.com/free-photo/young-handsome-physician-medical-robe-with-stethoscope_1303-17818.jpg?t=st=1746139347~exp=1746142947~hmac=c73e58a65605a23c92ca600973692cc8372440233a35d7e4552b6ae9d820da4c&w=1060');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    background-repeat: no-repeat;
    /* No overlay - image full visible */
}

.signup-card {
    background: rgba(255, 255, 255, 0.92); /* Card ko transparent */
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    max-width: 1100px;
    width: 100%;
    backdrop-filter: blur(10px); /* Zyada blur for better readability */
    border: 1px solid rgba(255, 255, 255, 0.5);
}

        .signup-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        .signup-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1100px;
            width: 100%;
        }

        .signup-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 40px;
            text-align: center;
        }

        .signup-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .signup-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .signup-body {
            padding: 40px;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border-color);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(62, 162, 147, 0.1);
        }

        /* Error states */
        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
        }

        .input-group-text {
            background-color: var(--background-light);
            border: 2px solid var(--border-color);
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .required-field::after {
            content: " *";
            color: var(--secondary-color);
        }

        .error-message {
            color: var(--secondary-color);
            font-size: 0.875rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-signup {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 50px;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        .btn-signup:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(62, 162, 147, 0.3);
        }

        .login-link {
            text-align: center;
            margin-top: 30px;
            color: var(--text-light);
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Toggle button styling */
        .toggle-btn {
            background: var(--background-light);
            border: 2px solid var(--border-color);
            border-left: none;
            border-radius: 0 10px 10px 0;
            color: var(--text-light);
            transition: all 0.3s ease;
        }

        .toggle-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Alert styling */
        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 20px;
        }

        .alert-success {
            background: rgba(72, 187, 120, 0.1);
            color: #22543D;
        }

        .alert-danger {
            background: rgba(245, 101, 101, 0.1);
            color: #742A2A;
        }

        /* Gender radio buttons */
        .gender-options {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }

        .gender-option {
            flex: 1;
        }

        .gender-option input[type="radio"] {
            display: none;
        }

        .gender-option label {
            display: block;
            padding: 12px 20px;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .gender-option input[type="radio"]:checked+label {
            border-color: var(--primary-color);
            background: rgba(62, 162, 147, 0.1);
            color: var(--primary-color);
            font-weight: 600;
        }

        .gender-option label:hover {
            border-color: var(--primary-color);
        }

        /* Input group with error */
        .input-group.has-error .input-group-text {
            border-color: var(--secondary-color);
        }
    </style>
    <div class="signup-container">
        <div class="signup-card">
            <div class="signup-header">
                <h1><i class="fas fa-user-plus me-2"></i>Create Your Account</h1>
                <p>Join thousands of patients managing their healthcare online</p>
            </div>

            <div class="signup-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('patient.signup.post') }}" method="POST" id="signupForm" novalidate>
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-user me-2"></i>Personal Information
                        </h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label required-field">First Name</label>
                                <div class="input-group @error('first_name') has-error @enderror">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="first_name" id="first_name"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        placeholder="Enter your first name" value="{{ old('first_name') }}" required>
                                </div>
                                @error('first_name')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label required-field">Last Name</label>
                                <div class="input-group @error('last_name') has-error @enderror">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="last_name" id="last_name"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        placeholder="Enter your last name" value="{{ old('last_name') }}" required>
                                </div>
                                @error('last_name')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label required-field">Date of Birth</label>
                                <div class="input-group @error('date_of_birth') has-error @enderror">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" name="date_of_birth" id="date_of_birth"
                                        class="form-control @error('date_of_birth') is-invalid @enderror"
                                        value="{{ old('date_of_birth') }}" max="{{ date('Y-m-d') }}" required>
                                </div>
                                @error('date_of_birth')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label required-field">Email Address</label>
                                <div class="input-group @error('email') has-error @enderror">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Enter your email address" value="{{ old('email') }}" required>
                                </div>
                                @error('email')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="cnic" class="form-label required-field">CNIC Number</label>
                                <div class="input-group @error('cnic') has-error @enderror">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="cnic" id="cnic"
                                        class="form-control @error('cnic') is-invalid @enderror"
                                        placeholder="00000-0000000-0" value="{{ old('cnic') }}" required>
                                </div>
                                @error('cnic')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-lock me-2"></i>Account Security
                        </h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label required-field">Password</label>
                                <div class="input-group @error('password') has-error @enderror">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Create a strong password" required>
                                    <button class="btn toggle-btn" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label required-field">Confirm
                                    Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" placeholder="Confirm your password" required>
                                    <button class="btn toggle-btn" type="button" id="togglePasswordConfirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Contact Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-phone me-2"></i>Contact Information
                        </h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contact_number" class="form-label required-field">Contact Number</label>
                                <div class="input-group @error('contact_number') has-error @enderror">
                                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                    <input type="text" name="contact_number" id="contact_number"
                                        class="form-control @error('contact_number') is-invalid @enderror"
                                        placeholder="0300-1234567" value="{{ old('contact_number') }}" required>
                                </div>
                                @error('contact_number')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="emergency_contact" class="form-label required-field">Emergency Contact</label>
                                <div class="input-group @error('emergency_contact') has-error @enderror">
                                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                    <input type="text" name="emergency_contact" id="emergency_contact"
                                        class="form-control @error('emergency_contact') is-invalid @enderror"
                                        placeholder="0300-7654321" value="{{ old('emergency_contact') }}" required>
                                </div>
                                @error('emergency_contact')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="address" class="form-label required-field">Complete Address</label>
                                <div class="input-group @error('address') has-error @enderror">
                                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="3"
                                        placeholder="Enter your complete address" required>{{ old('address') }}</textarea>
                                </div>
                                @error('address')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label required-field">City</label>
                                <div class="input-group @error('city') has-error @enderror">
                                    <span class="input-group-text"><i class="fas fa-city"></i></span>
                                    <input type="text" name="city" id="city"
                                        class="form-control @error('city') is-invalid @enderror" placeholder="Your city"
                                        value="{{ old('city') }}" required>
                                </div>
                                @error('city')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- <div class="col-md-4 mb-3">
                                <label for="state" class="form-label required-field">State/Province</label>
                                <div class="input-group @error('state') has-error @enderror">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" name="state" id="state"
                                        class="form-control @error('state') is-invalid @enderror"
                                        placeholder="Your state" value="{{ old('state') }}" required>
                                </div>
                                @error('state')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div> --}}

                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label required-field">State/Province</label>
                                <div class="input-group @error('state') has-error @enderror">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <select name="state" id="state"
                                        class="form-select @error('state') is-invalid @enderror" required>
                                        <option value="">Select Province</option>
                                        <option value="Punjab" {{ old('state') == 'Punjab' ? 'selected' : '' }}>Punjab
                                        </option>
                                        <option value="Sindh" {{ old('state') == 'Sindh' ? 'selected' : '' }}>Sindh
                                        </option>
                                        <option value="Balochistan" {{ old('state') == 'Balochistan' ? 'selected' : '' }}>
                                            Balochistan</option>
                                        <option value="Khyber Pakhtunkhwa"
                                            {{ old('state') == 'Khyber Pakhtunkhwa' ? 'selected' : '' }}>Khyber Pakhtunkhwa
                                        </option>
                                        <option value="Gilgit-Baltistan"
                                            {{ old('state') == 'Gilgit-Baltistan' ? 'selected' : '' }}>Gilgit-Baltistan
                                        </option>
                                        <option value="Azad Jammu and Kashmir"
                                            {{ old('state') == 'Azad Jammu and Kashmir' ? 'selected' : '' }}>Azad Jammu and
                                            Kashmir</option>
                                        <option value="Islamabad Capital Territory"
                                            {{ old('state') == 'Islamabad Capital Territory' ? 'selected' : '' }}>Islamabad
                                            Capital Territory</option>
                                    </select>
                                </div>
                                @error('state')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="zip_code" class="form-label required-field">ZIP Code</label>
                                <div class="input-group @error('zip_code') has-error @enderror">
                                    <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                    <input type="text" name="zip_code" id="zip_code"
                                        class="form-control @error('zip_code') is-invalid @enderror"
                                        placeholder="ZIP code" value="{{ old('zip_code') }}" required>
                                </div>
                                @error('zip_code')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Medical Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-heartbeat me-2"></i>Medical Information
                        </h3>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="blood_group" class="form-label required-field">Blood Group</label>
                                <select name="blood_group" id="blood_group"
                                    class="form-select @error('blood_group') is-invalid @enderror" required>
                                    <option value="">Select Blood Group</option>
                                    <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+
                                    </option>
                                    <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-
                                    </option>
                                    <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                                @error('blood_group')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="marital_status" class="form-label">Marital Status</label>
                                <select name="marital_status" id="marital_status"
                                    class="form-select @error('marital_status') is-invalid @enderror">
                                    <option value="">Select Status</option>
                                    <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>
                                        Single</option>
                                    <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>
                                        Married</option>
                                    <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>
                                        Divorced</option>
                                    <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>
                                        Widowed</option>
                                </select>
                                @error('marital_status')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="medical_history" class="form-label">Medical History (Optional)</label>
                                <textarea name="medical_history" id="medical_history"
                                    class="form-control @error('medical_history') is-invalid @enderror" rows="3"
                                    placeholder="Any previous medical conditions, allergies, or ongoing treatments">{{ old('medical_history') }}</textarea>
                                @error('medical_history')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Account Security Section -->
                    {{-- <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-lock me-2"></i>Account Security
                        </h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label required-field">Password</label>
                                <div class="input-group @error('password') has-error @enderror">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Create a strong password" required>
                                    <button class="btn toggle-btn" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label required-field">Confirm
                                    Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" placeholder="Confirm your password" required>
                                    <button class="btn toggle-btn" type="button" id="togglePasswordConfirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <button type="submit" class="btn btn-signup">
                        <i class="fas fa-user-plus me-2"></i> Create My Account
                    </button>
                </form>

                <div class="login-link">
                    Already have an account? <a href="{{ route('patient.signin') }}">Sign In</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const togglePassword = document.querySelector('#togglePassword');
            const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
            const password = document.querySelector('#password');
            const passwordConfirmation = document.querySelector('#password_confirmation');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });

            togglePasswordConfirmation.addEventListener('click', function() {
                const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmation.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });

            // Real-time validation
            const form = document.getElementById('signupForm');
            const inputs = form.querySelectorAll('input, select, textarea');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        validateField(this);
                    }
                });
            });

            function validateField(field) {
                // Remove existing error styling
                field.classList.remove('is-invalid');

                // Simple validation logic (you can enhance this)
                if (field.hasAttribute('required') && !field.value.trim()) {
                    field.classList.add('is-invalid');
                }

                if (field.type === 'email' && field.value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(field.value)) {
                        field.classList.add('is-invalid');
                    }
                }
            }
        });
    </script>
@endsection
