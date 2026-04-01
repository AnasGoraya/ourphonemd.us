
@extends('layouts.patient')

@section('title', 'Book an Appointment - Step 3')

@section('content')

    <style>
        .text-customTeal {
            color: rgb(87, 165, 150) !important;

        .bg-customTeal {
            background-color: rgb(87, 165, 150) !important;
        }

        [class*="sidebar-light-"] .nav-sidebar>.nav-item>.nav-link.active {
            background-color: rgb(87, 165, 150) !important;
            color: #fff !important;
        }

        .btn-customTeal {
            background-color: rgb(87, 165, 150) !important;
            border-color: rgb(87, 165, 150) !important;
            color: white !important;
        }

        .btn-customTeal:hover {
            background-color: rgba(87, 165, 150, 0.9) !important;
        }

        .progress-bar-customTeal {
            background-color: rgb(87, 165, 150) !important;
        }

        .card-header-customTeal {
            background-color: rgba(87, 165, 150, 0.1) !important;
            border-bottom: 1px solid rgba(87, 165, 150, 0.3) !important;
        }

        .form-control:focus {
            border-color: rgb(87, 165, 150) !important;
            box-shadow: 0 0 0 0.2rem rgba(87, 165, 150, 0.25) !important;
        }

        .custom-radio .custom-control-input:checked~.custom-control-label::before {
            background-color: rgb(87, 165, 150) !important;
            border-color: rgb(87, 165, 150) !important;
        }

        .file-upload {
            border: 2px dashed #ddd;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }

        .file-upload:hover {
            border-color: rgb(87, 165, 150);
            background: rgba(87, 165, 150, 0.05);
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('patient.appointment.dashboard') }}" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> Back to Appointments
                </a>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Book an Appointment</h3>
                        <br>
                        <p class="text-muted mb-0">Complete the form below to schedule your appointment</p>
                    </div>
                    <div class="card-body">
                        <!-- Wizard Bar -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between" style="gap: 0.5rem;">
                                <div class="wizard-step active">1</div>
                                <div class="wizard-bar"></div>
                                <div class="wizard-step active">2</div>
                                <div class="wizard-bar"></div>
                                <div class="wizard-step active">3</div>
                                <div class="wizard-bar"></div>
                                <div class="wizard-step">4</div>
                            </div>
                        </div>
                        <style>
                            .wizard-step {
                                width: 38px;
                                height: 38px;
                                border-radius: 50%;
                                background: #e3e6f0;
                                color: #aaa;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                font-weight: 700;
                                font-size: 1.2rem;
                                box-shadow: 0 2px 6px rgba(87,165,150,0.08);
                                border: 2px solid #e3e6f0;
                                transition: background 0.2s, color 0.2s;
                            }
                            .wizard-step.active {
                                background: rgb(87, 165, 150);
                                color: #fff;
                                border-color: rgb(87, 165, 150);
                            }
                            .wizard-bar {
                                flex: 1;
                                height: 4px;
                                background: linear-gradient(90deg, rgb(87, 165, 150) 100%, #e3e6f0 100%);
                                border-radius: 2px;
                                margin: 0 2px;
                            }
                        </style>

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('patient.appointments.wizard.step3.post') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card card-outline card-success mb-4" style="background-color: #EDF6F4;">
                                <div class="card-header">
                                    <h3 class="card-title">Selected Member Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Name:</strong><br>
                                                @if($selectedMember && $selectedMember['type'] === 'family')
                                                    {{ $selectedMember['first_name'] }} {{ $selectedMember['last_name'] }}
                                                @else
                                                    {{ Auth::guard('patient')->user()->first_name }} {{ Auth::guard('patient')->user()->last_name }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Type:</strong><br>
                                                @if($selectedMember && $selectedMember['type'] === 'family')
                                                    Family Member ({{ $selectedMember['relationship'] }})
                                                @else
                                                    Self
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Appointment Type</label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="appointment-type-adhd"
                                        name="appointment_type" value="adhd">
                                    <label for="appointment-type-adhd" class="custom-control-label">ADHD/Anxiety
                                        Follow-up</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="appointment-type-sick"
                                        name="appointment_type" value="sick" checked>
                                    <label for="appointment-type-sick" class="custom-control-label">Sick Visit</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Appointment Mode</label>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="in-person"
                                                name="appointment_mode" value="in-person" checked>
                                            <label for="in-person" class="custom-control-label">In-Person</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="telemedicine"
                                                name="appointment_mode" value="telemedicine">
                                            <label for="telemedicine" class="custom-control-label">Telemedicine</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="appointment_time">
                                            <i class="far fa-clock"></i> Appointment Time
                                        </label>
                                        <input type="time" class="form-control" id="appointment_time"
                                            name="appointment_time" required>
                                    </div>
                                </div>

                                <div class="col-md-6 text-center">
                                    <div class="bg-customTeal text-white p-3 rounded">
                                        <i class="fas fa-video mr-2"></i>
                                        <span class="font-weight-bold">Video Consultation</span>
                                    </div>
                                    <p class="text-danger mt-2 small">* In case of video call missed, doctor will
                                        contact you on your mentioned number.</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="doctor_id">
                                    <i class="fas fa-user-md"></i> Select Doctor
                                </label>
                                <select name="doctor_id" id="doctor_id" class="form-control" required>
                                    <option value="">Choose a doctor...</option>
                                    @foreach ($doctors ?? [] as $doctor)
                                        <option value="{{ $doctor->id }}">Dr. {{ $doctor->name }} - $100.00</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="appointment_date">
                                    <i class="far fa-calendar-alt"></i> Appointment Date
                                </label>
                                <input type="date" class="form-control" id="appointment_date"
                                    name="appointment_date" min="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="reason">Reason for Visit <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="reason" name="reason" rows="3"
                                    placeholder="Please describe the main reason for this appointment..." required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="symptoms">Current Symptoms <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="symptoms" name="symptoms" rows="3"
                                    placeholder="Please describe any current symptoms you're experiencing..." required></textarea>
                            <div class="form-group">
                                <label for="medications">Current Medications (Optional)</label>
                                <textarea class="form-control" id="medications" name="medications" rows="3"
                                    placeholder="Please list any medications you're currently taking..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="allergies">Allergies (Optional)</label>
                                <textarea class="form-control" id="allergies" name="allergies" rows="2"
                                    placeholder="Please list any known allergies..."></textarea>
                            </div>

                            <div class="form-group">
                                <label>Require school excuse/Work notes?</label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="work-note-yes"
                                        name="work_note" value="yes">
                                    <label for="work-note-yes" class="custom-control-label">Yes</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="work-note-no"
                                        name="work_note" value="no" checked>
                                    <label for="work-note-no" class="custom-control-label">No</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Is there any other Phone Number, you want Doctor to call?</label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="alt-phone-yes"
                                        name="alt_phone" value="yes">
                                    <label for="alt-phone-yes" class="custom-control-label">Yes</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="alt-phone-no"
                                        name="alt_phone" value="no" checked>
                                    <label for="alt-phone-no" class="custom-control-label">No</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="images">Attach Images (Optional)</label>
                                <div class="file-upload">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-2">Drag & drop or click to upload</p>
                                    <p class="text-muted small mb-3">JPG, PNG up to 5MB — up to 3 images</p>
                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                        onclick="document.getElementById('attached-images-input').click()">
                                        Select Images
                                    </button>
                                    <input id="attached-images-input" name="images[]" accept="image/*" multiple
                                        type="file" class="d-none">
                                </div>
                                <small class="form-text text-muted">Upload up to 3 images related to your symptoms or
                                    condition</small>
                            </div>

                            <div class="form-group">
                                <label>Any Medical History</label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="yes-medical-history"
                                        name="medical_history" value="yes">
                                    <label for="yes-medical-history" class="custom-control-label">Yes</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="no-medical-history"
                                        name="medical_history" value="no" checked>
                                    <label for="no-medical-history" class="custom-control-label">No</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="notes">Additional Notes (Optional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"
                                    placeholder="Any additional information you'd like the doctor to know..."></textarea>
                            </div>

                            <div class="card-footer">
                                <button type="button" onclick="window.history.back()" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i> Previous
                                </button>
                                <button type="submit" class="btn btn-customTeal float-right">
                                    Next <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection













































