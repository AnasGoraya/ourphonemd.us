@extends('layouts.patient')

@section('title', 'Patient Sign Up')

@section('content')
<style>
    .signup-card {
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        border-radius: 12px;
        padding: 30px;
        margin-top: 50px;
        background-color: #fff;
    }
    .form-label { font-weight: 600; color: #333; }
    .form-control {
        border-radius: 8px;
        margin-bottom: 18px;
        padding: 10px 12px;
    }
    .form-control:focus {
        border-color: #3EA293;
        box-shadow: 0 0 5px rgba(62, 162, 147, 0.4);
    }
    .btn-primary {
        background-color: #3EA293;
        border: none;
        border-radius: 8px;
        padding: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-primary:hover { background-color: #318C7E; }
    .alert { margin-bottom: 20px; border-radius: 8px; }
    .error { color: red; font-size: 14px; margin-top: -12px; margin-bottom: 10px; }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="signup-card">
                <h3 class="text-center mb-4" style="color: #3EA293;">Create Patient Account</h3>

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Error Message --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="patientSignupForm" action="{{ route('patient.signup.post') }}" method="POST" novalidate>
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>

                    {{-- ✅ Confirm Password Added --}}
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">CNIC</label>
                            <input type="text" name="cnic" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Emergency Contact</label>
                            <input type="text" name="emergency_contact" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Blood Group</label>
                            <select name="blood_group" class="form-control" required>
                                <option value="">Select</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                    </div>

                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" required>

                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ZIP Code</label>
                            <input type="text" name="zip_code" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Marital Status</label>
                            <select name="marital_status" class="form-control">
                                <option value="">Select</option>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Age</label>
                            <input type="number" name="age" class="form-control">
                        </div>
                    </div>

                    <label class="form-label">Medical History</label>
                    <textarea name="medical_history" class="form-control" rows="3"></textarea>

                    <button type="submit" class="btn btn-primary w-100 mt-3">Create Account</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ✅ jQuery Validation --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function() {
    $("#patientSignupForm").validate({
        rules: {
            first_name: { required: true, lettersonly: true },
            last_name: { required: true, lettersonly: true },
            email: { required: true, email: true },
            password: { required: true, minlength: 6 },
            password_confirmation: { required: true, equalTo: '[name="password"]' },
            gender: { required: true },
            date_of_birth: { required: true, date: true },
            cnic: { required: true, minlength: 13 },
            contact_number: { required: true },
            emergency_contact: { required: true },
            address: { required: true },
            city: { required: true },
            state: { required: true },
            zip_code: { required: true },
            blood_group: { required: true }
        },
        messages: {
            first_name: "Please enter your first name (letters only)",
            last_name: "Please enter your last name (letters only)",
            email: "Please enter a valid email address",
            password: {
                required: "Please provide a password",
                minlength: "Password must be at least 6 characters"
            },
            password_confirmation: {
                required: "Please confirm your password",
                equalTo: "Passwords do not match"
            },
            gender: "Please select your gender",
            date_of_birth: "Please select your date of birth",
            cnic: "Please enter a valid CNIC number",
            contact_number: "Please enter your contact number",
            emergency_contact: "Please enter emergency contact",
            address: "Please enter your address",
            city: "Please enter your city",
            state: "Please enter your state",
            zip_code: "Please enter ZIP code",
            blood_group: "Please select your blood group"
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    // Allow only letters for name fields
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Letters only please");
});
</script>
@endsection



















@extends('layouts.patient')

@section('title', 'Sign Up - OurPhoneMD')

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

    .signup-container {
        min-height: 100vh;
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
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

    .form-control, .form-select {
        border: 2px solid var(--border-color);
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(62, 162, 147, 0.1);
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
        display: none;
        color: var(--secondary-color);
        font-size: 0.875rem;
        margin-top: 5px;
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

    .gender-option input[type="radio"]:checked + label {
        border-color: var(--primary-color);
        background: rgba(62, 162, 147, 0.1);
        color: var(--primary-color);
        font-weight: 600;
    }

    .gender-option label:hover {
        border-color: var(--primary-color);
    }
</style>

<div class="signup-container">
    <div class="signup-card">
        <div class="signup-header">
            <h1><i class="fas fa-user-plus me-2"></i>Create Your Account</h1>
            <p>Join thousands of patients managing their healthcare online</p>
        </div>

        <div class="signup-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
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
                            <div class="first-name-error error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>Special characters and numbers are not allowed.
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                       placeholder="Enter your first name" value="{{ old('first_name') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label required-field">Last Name</label>
                            <div class="last-name-error error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>Special characters and numbers are not allowed.
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="last_name" id="last_name" class="form-control"
                                       placeholder="Enter your last name" value="{{ old('last_name') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Gender</label>
                            <div class="gender-options">
                                <div class="gender-option">
                                    <input type="radio" id="male" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                    <label for="male"><i class="fas fa-male me-2"></i>Male</label>
                                </div>
                                <div class="gender-option">
                                    <input type="radio" id="female" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} required>
                                    <label for="female"><i class="fas fa-female me-2"></i>Female</label>
                                </div>
                                <div class="gender-option">
                                    <input type="radio" id="other" name="gender" value="other" {{ old('gender') == 'other' ? 'checked' : '' }} required>
                                    <label for="other"><i class="fas fa-user me-2"></i>Other</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label required-field">Date of Birth</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                                       value="{{ old('date_of_birth') }}" max="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label required-field">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control"
                                       placeholder="Enter your email address" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cnic" class="form-label required-field">CNIC Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" name="cnic" id="cnic" class="form-control"
                                       placeholder="00000-0000000-0" value="{{ old('cnic') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-phone me-2"></i>Contact Information
                    </h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contact_number" class="form-label required-field">Contact Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                <input type="text" name="contact_number" id="contact_number" class="form-control"
                                       placeholder="0300-1234567" value="{{ old('contact_number') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="emergency_contact" class="form-label required-field">Emergency Contact</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                <input type="text" name="emergency_contact" id="emergency_contact" class="form-control"
                                       placeholder="0300-7654321" value="{{ old('emergency_contact') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label required-field">Complete Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                <textarea name="address" id="address" class="form-control" rows="3"
                                          placeholder="Enter your complete address" required>{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="city" class="form-label required-field">City</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-city"></i></span>
                                <input type="text" name="city" id="city" class="form-control"
                                       placeholder="Your city" value="{{ old('city') }}" required>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="state" class="form-label required-field">State/Province</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" name="state" id="state" class="form-control"
                                       placeholder="Your state" value="{{ old('state') }}" required>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="zip_code" class="form-label required-field">ZIP Code</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                <input type="text" name="zip_code" id="zip_code" class="form-control"
                                       placeholder="ZIP code" value="{{ old('zip_code') }}" required>
                            </div>
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
                            <select name="blood_group" id="blood_group" class="form-select" required>
                                <option value="">Select Blood Group</option>
                                <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                        </div>



                        <div class="col-md-4 mb-3">
                            <label for="marital_status" class="form-label">Marital Status</label>
                            <select name="marital_status" id="marital_status" class="form-select">
                                <option value="">Select Status</option>
                                <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Married</option>
                                <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="medical_history" class="form-label">Medical History (Optional)</label>
                            <textarea name="medical_history" id="medical_history" class="form-control" rows="3"
                                      placeholder="Any previous medical conditions, allergies, or ongoing treatments">{{ old('medical_history') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Account Security Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-lock me-2"></i>Account Security
                    </h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label required-field">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control"
                                       placeholder="Create a strong password" required>
                                <button class="btn toggle-btn" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label required-field">Confirm Password</label>
                            <div class="password-match-error error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>Passwords do not match.
                            </div>
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

                <button type="submit" class="btn btn-signup">
                    <i class="fas fa-user-plus me-2"></i> Create My Account
                </button>
            </form>

            <div class="login-link">
                <p>Already have an account?
                    <a href="{{ route('patient.signin') }}">Sign in to your account</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Auto-calculate age from date of birth
    $('#date_of_birth').change(function() {
        const dob = new Date($(this).val());
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        $('#age').val(age);
    });

    // Real-time name validation
    $('#first_name, #last_name').on('input', function () {
        const field = $(this);
        const value = field.val().trim();
        const regex = /^[A-Za-z\s]*$/;
        const errorElement = field.closest('.mb-3').find('.error-message');

        if (value === '') {
            errorElement.hide();
            return;
        }

        if (!regex.test(value)) {
            field.addClass('is-invalid');
            errorElement.show();
        } else {
            field.removeClass('is-invalid');
            errorElement.hide();
        }
    });

    // Real-time password match validation
    $('#password_confirmation').on('input', function () {
        const password = $('#password').val();
        const confirmPassword = $(this).val();
        const errorElement = $('.password-match-error');

        if (confirmPassword === '') {
            errorElement.hide();
            return;
        }

        if (password !== confirmPassword) {
            $(this).addClass('is-invalid');
            errorElement.show();
        } else {
            $(this).removeClass('is-invalid');
            errorElement.hide();
        }
    });

// Form submission validation - UPDATED VERSION
$('form').on('submit', function (e) {
    let valid = true;
    const firstName = $('#first_name').val().trim();
    const lastName = $('#last_name').val().trim();
    const password = $('#password').val();
    const confirmPassword = $('#password_confirmation').val();
    const nameRegex = /^[A-Za-z\s]+$/;

    // Hide all errors first
    $('.error-message').hide();
    $('.is-invalid').removeClass('is-invalid');

    // Validate first name
    if (!nameRegex.test(firstName)) {
        $('#first_name').addClass('is-invalid');
        $('.first-name-error').show();
        if (valid) $('#first_name').focus();
        valid = false;
    }

    // Validate last name
    if (!nameRegex.test(lastName)) {
        $('#last_name').addClass('is-invalid');
        $('.last-name-error').show();
        if (valid) $('#last_name').focus();
        valid = false;
    }

    // Validate password match
    if (password !== confirmPassword) {
        $('#password_confirmation').addClass('is-invalid');
        $('.password-match-error').show();
        if (valid) $('#password_confirmation').focus();
        valid = false;
    }

    // Validate required fields
    $('input[required], select[required], textarea[required]').each(function () {
        if ($(this).val().trim() === '') {
            $(this).addClass('is-invalid');
            if (valid) $(this).focus();
            valid = false;
        }
    });

    // Validate gender (special handling for radio buttons)
    const genderSelected = $('input[name="gender"]:checked').length > 0;
    if (!genderSelected) {
        $('.gender-options').addClass('is-invalid');
        if (valid) $('input[name="gender"]').first().focus();
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
        // Scroll to first error
        $('html, body').animate({
            scrollTop: $('.is-invalid').first().offset().top - 100
        }, 500);
    } else {
        // Show loading state
        $('.btn-signup').html('<i class="fas fa-spinner fa-spin me-2"></i> Creating Account...');
        $('.btn-signup').prop('disabled', true);
    }
});

    // Toggle password visibility
    $('#togglePassword, #togglePasswordConfirmation').on('click', function () {
        const input = $(this).closest('.input-group').find('input');
        const type = input.attr('type') === 'password' ? 'text' : 'password';
        const icon = $(this).find('i');

        input.attr('type', type);
        icon.toggleClass('fa-eye fa-eye-slash');
    });
});
</script>
@endsection











sai

@extends('layouts.patient')

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

    .signup-container {
        min-height: 100vh;
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
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

    .form-control, .form-select {
        border: 2px solid var(--border-color);
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(62, 162, 147, 0.1);
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
        display: none;
        color: var(--secondary-color);
        font-size: 0.875rem;
        margin-top: 5px;
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

    .gender-option input[type="radio"]:checked + label {
        border-color: var(--primary-color);
        background: rgba(62, 162, 147, 0.1);
        color: var(--primary-color);
        font-weight: 600;
    }

    .gender-option label:hover {
        border-color: var(--primary-color);
    }
</style>
<div class="signup-container">
    <div class="signup-card">
        <div class="signup-header">
            <h1><i class="fas fa-user-plus me-2"></i>Create Your Account</h1>
            <p>Join thousands of patients managing their healthcare online</p>
        </div>

        <div class="signup-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
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
                            <div class="first-name-error error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>Special characters and numbers are not allowed.
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                       placeholder="Enter your first name" value="{{ old('first_name') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label required-field">Last Name</label>
                            <div class="last-name-error error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>Special characters and numbers are not allowed.
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="last_name" id="last_name" class="form-control"
                                       placeholder="Enter your last name" value="{{ old('last_name') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                       <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label required-field">Date of Birth</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                                       value="{{ old('date_of_birth') }}" max="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label required-field">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control"
                                       placeholder="Enter your email address" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cnic" class="form-label required-field">CNIC Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" name="cnic" id="cnic" class="form-control"
                                       placeholder="00000-0000000-0" value="{{ old('cnic') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-phone me-2"></i>Contact Information
                    </h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contact_number" class="form-label required-field">Contact Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                <input type="text" name="contact_number" id="contact_number" class="form-control"
                                       placeholder="0300-1234567" value="{{ old('contact_number') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="emergency_contact" class="form-label required-field">Emergency Contact</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                <input type="text" name="emergency_contact" id="emergency_contact" class="form-control"
                                       placeholder="0300-7654321" value="{{ old('emergency_contact') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label required-field">Complete Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                <textarea name="address" id="address" class="form-control" rows="3"
                                          placeholder="Enter your complete address" required>{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="city" class="form-label required-field">City</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-city"></i></span>
                                <input type="text" name="city" id="city" class="form-control"
                                       placeholder="Your city" value="{{ old('city') }}" required>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="state" class="form-label required-field">State/Province</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" name="state" id="state" class="form-control"
                                       placeholder="Your state" value="{{ old('state') }}" required>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="zip_code" class="form-label required-field">ZIP Code</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                <input type="text" name="zip_code" id="zip_code" class="form-control"
                                       placeholder="ZIP code" value="{{ old('zip_code') }}" required>
                            </div>
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
                            <select name="blood_group" id="blood_group" class="form-select" required>
                                <option value="">Select Blood Group</option>
                                <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                        </div>



                        <div class="col-md-4 mb-3">
                            <label for="marital_status" class="form-label">Marital Status</label>
                            <select name="marital_status" id="marital_status" class="form-select">
                                <option value="">Select Status</option>
                                <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Married</option>
                                <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="medical_history" class="form-label">Medical History (Optional)</label>
                            <textarea name="medical_history" id="medical_history" class="form-control" rows="3"
                                      placeholder="Any previous medical conditions, allergies, or ongoing treatments">{{ old('medical_history') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Account Security Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-lock me-2"></i>Account Security
                    </h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label required-field">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control"
                                       placeholder="Create a strong password" required>
                                <button class="btn toggle-btn" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label required-field">Confirm Password</label>
                            <div class="password-match-error error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>Passwords do not match.
                            </div>
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

                <button type="submit" class="btn btn-signup">
                    <i class="fas fa-user-plus me-2"></i> Create My Account
                </button>
            </form>

            </div>
        </div>
    </div>
</div>

{{-- ✅ jQuery Validation --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function() {
    $("#patientSignupForm").validate({
        rules: {
            first_name: { required: true, lettersonly: true },
            last_name: { required: true, lettersonly: true },
            email: { required: true, email: true },
            password: { required: true, minlength: 6 },
            password_confirmation: { required: true, equalTo: '[name="password"]' },
            gender: { required: true },
            date_of_birth: { required: true, date: true },
            cnic: { required: true, minlength: 13 },
            contact_number: { required: true },
            emergency_contact: { required: true },
            address: { required: true },
            city: { required: true },
            state: { required: true },
            zip_code: { required: true },
            blood_group: { required: true }
        },
        messages: {
            first_name: "Please enter your first name (letters only)",
            last_name: "Please enter your last name (letters only)",
            email: "Please enter a valid email address",
            password: {
                required: "Please provide a password",
                minlength: "Password must be at least 6 characters"
            },
            password_confirmation: {
                required: "Please confirm your password",
                equalTo: "Passwords do not match"
            },
            date_of_birth: "Please select your date of birth",
            cnic: "Please enter a valid CNIC number",
            contact_number: "Please enter your contact number",
            emergency_contact: "Please enter emergency contact",
            address: "Please enter your address",
            city: "Please enter your city",
            state: "Please enter your state",
            zip_code: "Please enter ZIP code",
            blood_group: "Please select your blood group"
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    // Allow only letters for name fields
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Letters only please");
});
</script>
@endsection














