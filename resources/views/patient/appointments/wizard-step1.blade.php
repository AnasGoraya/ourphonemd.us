@extends('layouts.patient')

@section('title', 'Book an Appointment - Step 1')

@section('page_title', 'Book an Appointment - Step 1')

@section('content')
<style>
    .text-customTeal {
        color: rgb(87, 165, 150) !important;
        font-weight: 700 !important;
    }
    .bg-customTeal {
        background-color: rgb(87, 165, 150) !important;
    }
    .border-customTeal {
        border-color: rgb(87, 165, 150) !important;
    }
    .bg-green-500 {
        background-color: rgb(87, 165, 150) !important;
    }
    .btn-customTeal {
        background-color: #51A897 !important;
        color: #fff !important;
        border: none;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 8px;
        transition: background 0.2s;
    }
    .btn-customTeal:hover {
        background-color: #3e8c7e !important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="margin-top: 50px; margin-left: 20px;">
                <div class="card-header">
                    <h3 class="card-title">Book an Appointment</h3>
                    <div class="card-tools">
                        <a href="{{ route('patient.appointment.dashboard') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Appointments
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted">Complete the form below to schedule your appointment</p>

                    <!-- Wizard Bar -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between" style="gap: 0.5rem;">
                            <div class="wizard-step active">1</div>
                            <div class="wizard-bar"></div>
                            <div class="wizard-step">2</div>
                            <div class="wizard-bar"></div>
                            <div class="wizard-step">3</div>
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
                            background: linear-gradient(90deg, rgb(87, 165, 150) 0%, #e3e6f0 100%);
                            border-radius: 2px;
                            margin: 0 2px;
                        }
                    </style>

                    <form action="{{ route('patient.appointments.wizard.step1.post') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Is this an ADHD/Anxiety-Depression/ADHD Follow-up Appointment? <span class="text-danger">*</span></label>
                                    <div class="mt-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_adhd_appointment" id="adhd-yes" value="1" required>
                                            <label class="form-check-label" for="adhd-yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_adhd_appointment" id="adhd-no" value="0" required checked>
                                            <label class="form-check-label" for="adhd-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Please select whether this appointment is related to ADHD, Anxiety, Depression, or ADHD follow-up</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-customTeal float-right">
                                    Next <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
