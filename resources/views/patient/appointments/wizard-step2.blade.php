@extends('layouts.patient')

@section('title', 'Book an Appointment - Step 2')

@section('page_title', 'Book an Appointment - Step 2')

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
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="margin-top: 40px; margin-left: 30px;">
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

                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between" style="gap: 0.5rem;">
                            <div class="wizard-step active">1</div>
                            <div class="wizard-bar"></div>
                            <div class="wizard-step active">2</div>
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
                            background: linear-gradient(90deg, rgb(87, 165, 150) 60%, #e3e6f0 100%);
                            border-radius: 2px;
                            margin: 0 2px;
                        }
                    </style>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Validation Error!</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($errors->has('patient_selection'))
                        <div class="alert alert-warning">
                            <strong>Warning:</strong> {{ $errors->first('patient_selection') }}
                        </div>
                    @endif

                    <form action="{{ route('patient.appointments.wizard.step2.post') }}" method="POST" id="step2-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Select Patients for Appointment <span class="text-danger">*</span></label>
                                    <div class="mt-3">
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="patient_selection" id="patient-self" value="self" checked>
                                                    <label class="form-check-label" for="patient-self">
                                                        <strong>{{ Auth::guard('patient')->user()->first_name }} {{ Auth::guard('patient')->user()->last_name }}</strong> (Self)
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @foreach($familyMembers as $member)
                                            <div class="card mb-2">
                                                <div class="card-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="patient_selection" id="family-member-{{ $member->id }}" value="family_{{ $member->id }}">
                                                        <label class="form-check-label" for="family-member-{{ $member->id }}">
                                                            <strong>{{ $member->first_name }} {{ $member->last_name }}</strong> ({{ $member->relationship }})
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small class="form-text text-muted">Select who the appointment is for. Only one can be selected.</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="button" onclick="window.history.back()" class="btn btn-secondary btn-lg mr-2">
                                    <i class="fas fa-arrow-left mr-2"></i>Previous
                                </button>
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
