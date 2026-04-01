@extends('layouts.patient')
@section('title', 'Patient Dashboard - OurPhoneMD')

@section('adminlte_css')
    <style>
        body {
            background: #f8fafc;
        }
        .main-header {
            background: #fff !important;
            border-bottom: 1px solid #e5e7eb !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            min-height: 64px;
            padding: 20px 0;
        }
        .navbar-brand {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .navbar-nav .nav-link {
            color: #1a2e35 !important;
            font-weight: 500;
            font-size: 16px;
        }
        .navbar-nav .nav-link:hover {
            color: #3EA293 !important;
        }
        .action-btn, .action-btn.secondary {
            background: #3EA293 !important;
            color: #fff !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            padding: 10px 24px !important;
            box-shadow: 0 2px 8px rgba(62,162,147,0.08);
            border: none;
            margin-right: 10px;
            transition: background 0.2s;
        }
        .action-btn.secondary {
            background: #51A897 !important;
        }
        .action-btn:hover, .action-btn.secondary:hover {
            background: #2e8c7e !important;
            color: #fff !important;
        }
        .main-sidebar {
            background: #fff !important;
            border-right: 1.5px solid #e5e7eb !important;
            min-width: 250px;
            box-shadow: 2px 0 8px rgba(0,0,0,0.03);
        }
        .sidebar .nav-sidebar .nav-link {
            color: #1a2e35 !important;
            font-size: 16px;
            font-weight: 500;
            border-radius: 6px;
            margin-bottom: 6px;
            padding: 10px 18px;
            transition: background 0.2s;
        }
        .sidebar .nav-sidebar .nav-link.active, .sidebar .nav-sidebar .nav-link:hover {
            background: #e6f7f3 !important;
            color: #3EA293 !important;
        }
        .sidebar .nav-icon {
            margin-right: 10px;
            font-size: 18px;
        }
        .sidebar .user-panel {
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 18px;
            padding-bottom: 12px;
        }
        .sidebar .user-panel .info a {
            color: #1a2e35 !important;
            font-weight: 600;
        }
        .content-wrapper {
            background: #f8fafc !important;
            min-height: 100vh;
              padding-left: 0px !important; /* ← یہ لائن distance کم کرنے کے لیے */

        }
        .main-footer {
            background: #fff;
            border-top: 1px solid #e5e7eb;
            color: #888;
            font-size: 15px;
        }
        /* Dashboard Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-top: 32px;
        }
        .stat-card {
            background: #f9fdfc;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(62,162,147,0.07);
            padding: 32px 24px 24px 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-height: 180px;
            position: relative;
            border: 1.5px solid #e5e7eb;
        }
        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            font-size: 24px;
        }
        .stat-card .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1a2e35;
            margin-bottom: 6px;
        }
        .stat-card .stat-label {
            color: #3EA293;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 12px;
        }
        .stat-card .stat-link {
            color: #1976d2;
            font-size: 0.98rem;
            font-weight: 500;
            margin-top: auto;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .support-card {
            background: linear-gradient(135deg, #67e8f9 0%, #3EA293 100%);
            color: #fff;
            padding: 32px 24px;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-height: 180px;
            box-shadow: 0 2px 8px rgba(62,162,147,0.10);
        }
        .col-lg-9 {
    width: 75% !important; }
        .support-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .support-subtitle {
            font-size: 1.05rem;
            opacity: 0.95;
            margin-bottom: 18px;
        }
        .support-btn {
            background: #fff;
            color: #3EA293;
            padding: 10px 22px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(62,162,147,0.08);
            transition: background 0.2s, color 0.2s;
        }
        .support-btn:hover {
            background: #e6f7f3;
            color: #1976d2;
        }
        /* Divider lines */
        .sidebar hr, .main-header hr {
            border: none;
            border-top: 1.5px solid #e5e7eb;
            margin: 12px 0;
        }
        .sidebar .nav-sidebar {
            border-left: 2.5px solid #e5e7eb;
            padding-left: 8px;
        }
        .col-xl-11 {
    margin-right: 60px !important; /* try 20–40px for best alignment */
}

    </style>
@stop

@section('content')

        <!-- Content Wrapper -->
        <div class="content-wrapper"
            style="background-color: white !important;">
            <!-- Main content -->
            <section class="content">
                <div class="row justify-content-start pt-6">
                    <div class="col-xl-11 col-lg-11">
                                <!-- Top Card -->
                                <div class="card mb-4 shadow-sm rounded-4 border-0" style="padding: 0;">
                                    <div class="d-flex align-items-center px-4 py-4" style="gap: 32px;">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 90px; height: 90px; background: #51A897; color: #fff; font-size: 2.5rem; font-weight: 700;">
                                            {{ strtoupper(substr($patient->first_name,0,1)) }}{{ strtoupper(substr($patient->last_name,0,1)) }}
                                        </div>
                                        <div class="flex-grow-1">
                                            <h2 class="mb-1" style="font-weight:700; color:#222; font-size:2rem;">{{ $patient->first_name }} {{ $patient->last_name }}</h2>
                                            <div class="mb-1" style="color:#888; font-size:1rem;">Patient ID: <span style="font-weight:500;">{{ $patient->patient_id ?? 'N/A' }}</span></div>
                                            <span class="badge rounded-pill" style="background:#E6F7F3; color:#51A897; font-size:1rem; font-weight:500; padding:8px 18px;">Since {{ $patient->created_at ? $patient->created_at->format('M Y') : 'N/A' }}</span>
                                        </div>
                                        <div>
                                            <button id="editProfileBtn" class="btn" style="background:#EDF6F4; color:#222; font-weight:500; border-radius:8px; padding:10px 22px; font-size:1rem; box-shadow:0 2px 8px rgba(81,168,151,0.07);" onclick="toggleEditMode()">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="#51A897" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;vertical-align:middle;">
                                                    <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
                                                </svg>
                                                Edit Profile
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- View Mode -->
                                <div id="viewMode">
                                    <!-- Two Cards Below -->
                                    <div class="row g-4">
                                        <!-- Left Card: Info -->
                                        <div class="col-lg-9">
                                            <div class="card shadow-sm rounded-4 border-0" style="padding: 0;">
                                                <div class="row g-0">
                                                    <div class="col-md-6 p-4 border-end">
                                                        <h5 class="mb-3" style="font-weight:600; color:#51A897;">Basic Information</h5>
                                                        <div class="mb-2"><strong>Full Name:</strong> {{ $patient->first_name }} {{ $patient->last_name }}</div>
                                                        <div class="mb-2"><strong>Gender:</strong> {{ ucfirst($patient->gender) }}</div>
                                                        <div class="mb-2"><strong>Date of Birth:</strong> {{ $patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : '-' }}</div>
                                                    </div>
                                                    <div class="col-md-6 p-4">
                                                        <h5 class="mb-3" style="font-weight:600; color:#51A897;">Contact Details</h5>
                                                        <div class="mb-2"><strong>Email:</strong> {{ $patient->email }}</div>
                                                        <div class="mb-2"><strong>Phone:</strong> {{ $patient->contact_number }}</div>
                                                        <div class="mb-2"><strong>Secondary Phone:</strong> {{ $patient->secondary_phone ?? '-' }}</div>
                                                    </div>
                                                </div>
                                                <div class="row g-0 border-top">
                                                    <div class="col-md-6 p-4 border-end">
                                                        <h5 class="mb-3" style="font-weight:600; color:#51A897;">Address</h5>
                                                        <div class="mb-2"><strong>Street:</strong> {{ $patient->address }}</div>
                                                        <div class="mb-2"><strong>City, State ZIP:</strong> {{ $patient->city }}, {{ $patient->state }} {{ $patient->zip_code }}</div>
                                                    </div>
                                                    <div class="col-md-6 p-4">
                                                        <h5 class="mb-3" style="font-weight:600; color:#51A897;">Medical Information</h5>
                                                        <div class="mb-2"><strong>Blood Type:</strong> {{ $patient->blood_group ?? '-' }}</div>
                                                        <div class="mb-2"><strong>Allergies:</strong> {{ $patient->allergies ?? 'None' }}</div>
                                                    </div>
                                                </div>
                                                <div class="row g-0 border-top">
                                                    <div class="col-md-6 p-4 border-end">
                                                        <h5 class="mb-3" style="font-weight:600; color:#51A897;">Account Status</h5>
                                                        <div class="mb-2"><strong>Member Since:</strong> {{ $patient->created_at ? $patient->created_at->format('M d, Y') : '-' }}</div>
                                                        <div class="mb-2"><strong>Last Updated:</strong> {{ $patient->updated_at ? $patient->updated_at->format('M d, Y') : '-' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Right Card: Quick Actions -->
                                        <div class="col-lg-4">
                                            <div class="card shadow-sm rounded-4 border-0 p-4 d-flex flex-column justify-content-between" style="height:100%;">
                                                <h5 class="mb-3" style="font-weight:600; color:#51A897;">Quick Actions</h5>
                                                <a href="{{ route('patient.appointment.dashboard') }}" class="btn btn-outline-success mb-3" style="font-weight:500; font-size:1rem;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="#51A897" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;vertical-align:middle;">
                                                        <rect width="16" height="16" x="2" y="4" rx="2"/>
                                                        <line x1="2" x2="22" y1="10" y2="10"/>
                                                    </svg>
                                                    Book Appointment
                                                </a>
                                                <a href="{{ route('patient.contact-us') }}" class="btn btn-outline-info" style="font-weight:500; font-size:1rem;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="#51A897" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;vertical-align:middle;">
                                                        <circle cx="12" cy="12" r="10"/>
                                                        <line x1="12" x2="12" y1="8" y2="12"/>
                                                        <line x1="12" x2="12.01" y1="16" y2="16"/>
                                                    </svg>
                                                    Contact Support
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Mode -->
                                <div id="editMode" style="display: none;">
                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form action="{{ route('patient.profile.update') }}" method="POST">
                                        @csrf
                                        <div class="row g-4">
                                            <!-- Left Card: Edit Form -->
                                            <div class="col-lg-9">
                                                <div class="card shadow-sm rounded-4 border-0 p-4">
                                                    <h5 class="mb-4" style="font-weight:600; color:#51A897;">Edit Profile Information</h5>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="first_name" class="form-label">First Name</label>
                                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $patient->first_name) }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="last_name" class="form-label">Last Name</label>
                                                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $patient->email) }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="contact_number" class="form-label">Phone</label>
                                                            <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number', $patient->contact_number) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                                                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth ? $patient->date_of_birth->format('Y-m-d') : '') }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="cnic" class="form-label">CNIC</label>
                                                            <input type="text" class="form-control" id="cnic" name="cnic" value="{{ old('cnic', $patient->cnic) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="blood_group" class="form-label">Blood Group</label>
                                                            <select class="form-control" id="blood_group" name="blood_group" required>
                                                                <option value="">Select Blood Group</option>
                                                                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                                                    <option value="{{ $bg }}" {{ old('blood_group', $patient->blood_group) == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="gender" class="form-label">Gender</label>
                                                            <select class="form-control" id="gender" name="gender">
                                                                <option value="">Select Gender</option>
                                                                <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                                <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                                                <option value="other" {{ old('gender', $patient->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="marital_status" class="form-label">Marital Status</label>
                                                            <select class="form-control" id="marital_status" name="marital_status">
                                                                <option value="">Select Marital Status</option>
                                                                <option value="single" {{ old('marital_status', $patient->marital_status) == 'single' ? 'selected' : '' }}>Single</option>
                                                                <option value="married" {{ old('marital_status', $patient->marital_status) == 'married' ? 'selected' : '' }}>Married</option>
                                                                <option value="divorced" {{ old('marital_status', $patient->marital_status) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                                                <option value="widowed" {{ old('marital_status', $patient->marital_status) == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="emergency_contact" class="form-label">Emergency Contact</label>
                                                            <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact', $patient->emergency_contact) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label for="address" class="form-label">Address</label>
                                                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $patient->address) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 mb-3">
                                                            <label for="city" class="form-label">City</label>
                                                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $patient->city) }}" required>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="state" class="form-label">State</label>
                                                            <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $patient->state) }}" required>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="zip_code" class="form-label">ZIP Code</label>
                                                            <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code', $patient->zip_code) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label for="medical_history" class="form-label">Medical History</label>
                                                            <textarea class="form-control" id="medical_history" name="medical_history" rows="3">{{ old('medical_history', $patient->medical_history) }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-save me-2"></i>Save Changes
                                                        </button>
                                                        <button type="button" class="btn btn-secondary" onclick="toggleEditMode()">
                                                            <i class="fas fa-times me-2"></i>Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Right Card: Quick Actions -->
                                            <div class="col-lg-4">
                                                <div class="card shadow-sm rounded-4 border-0 p-4 d-flex flex-column justify-content-between" style="height:100%;">
                                                    <h5 class="mb-3" style="font-weight:600; color:#51A897;">Quick Actions</h5>
                                                    <a href="{{ route('patient.appointment.dashboard') }}" class="btn btn-outline-success mb-3" style="font-weight:500; font-size:1rem;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="#51A897" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;vertical-align:middle;">
                                                            <rect width="16" height="16" x="2" y="4" rx="2"/>
                                                            <line x1="2" x2="22" y1="10" y2="10"/>
                                                        </svg>
                                                        Book Appointment
                                                    </a>
                                                <a href="{{ route('patient.contact-us') }}" class="btn btn-outline-info" style="font-weight:500; font-size:1rem;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="#51A897" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;vertical-align:middle;">
                                                        <circle cx="12" cy="12" r="10"/>
                                                        <line x1="12" x2="12" y1="8" y2="12"/>
                                                        <line x1="12" x2="12.01" y1="16" y2="16"/>
                                                    </svg>
                                                    Contact Support
                                                </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

<style>
.card { border-radius: 1.25rem !important; }
.rounded-4 { border-radius: 1.25rem !important; }
.border-end { border-right: 1px solid #e3e6f0 !important; }
.border-top { border-top: 1px solid #e3e6f0 !important; }
@media (max-width: 991px) {
    .col-lg-8, .col-lg-4 { flex: 0 0 100%; max-width: 100%; }
    .card { margin-bottom: 24px; }
}
</style>

<script>
function toggleEditMode() {
    const viewMode = document.getElementById('viewMode');
    const editMode = document.getElementById('editMode');
    const editBtn = document.getElementById('editProfileBtn');

    if (editMode.style.display === 'none') {
        viewMode.style.display = 'none';
        editMode.style.display = 'block';
        editBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="#51A897" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;vertical-align:middle;">
                <path d="M19 12H5M21 12l-2 2-2-2M12 3v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Cancel Edit
        `;
    } else {
        viewMode.style.display = 'block';
        editMode.style.display = 'none';
        editBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="#51A897" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;vertical-align:middle;">
                <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
            </svg>
            Edit Profile
        `;
    }
}
</script>
@endsection
