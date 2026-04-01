@extends('layouts.patient')

@section('title', 'Work/School Notes - OurPhoneMD')

@section('content')
<div class="container-fluid py-4" style="max-width: 1200px;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-weight-bold mb-1" style="color: #2c3e50;">Work & School Notes</h1>
            <p class="text-muted">View and manage notes provided by your doctors.</p>
        </div>
        <a href="{{ route('patient.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
        </a>
    </div>

    <!-- Notes List -->
    @if($notes->count() > 0)
        <div class="row">
            @foreach($notes as $note)
                @php
                    $isFamilyNote = $note->appointment && $note->appointment->familyMember;
                    $familyMember = $isFamilyNote ? $note->appointment->familyMember : null;
                    $cardBorderColor = $isFamilyNote ? '#CFFAF3' : '#51A897'; // Light teal for family, Brand teal for patient
                    $badgeColor = $isFamilyNote ? 'bg-info' : 'bg-success';
                    $badgeStyle = $isFamilyNote ? 'background-color: #51A897 !important; color: white !important;' : 'background-color: #51A897 !important; color: white !important;';
                @endphp
                <div class="col-12 mb-3">
                    <div class="card border-0 shadow-sm" style="border-left: 5px solid {{ $cardBorderColor }} !important; border-radius: 8px;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    @if($isFamilyNote)
                                        <span class="badge {{ $badgeColor }} mb-2" style="font-size: 0.85rem; padding: 6px 12px; font-weight: 500; {{ $badgeStyle }}">
                                            <i class="fas fa-users me-1"></i> Family Member Note
                                        </span>
                                        <h5 class="font-weight-bold mt-1" style="color: #2c3e50;">
                                            For: <span style="color: #51A897;">{{ $familyMember->first_name }} {{ $familyMember->last_name }}</span>
                                            <small class="text-muted ml-1" style="font-size: 0.9rem;">({{ ucfirst($familyMember->relationship) }})</small>
                                        </h5>
                                    @else
                                        <span class="badge {{ $badgeColor }} mb-2" style="font-size: 0.85rem; padding: 6px 12px; font-weight: 500; {{ $badgeStyle }}">
                                            <i class="fas fa-user me-1"></i> My Note
                                        </span>
                                        <h5 class="font-weight-bold mt-1" style="color: #2c3e50;">For: Me</h5>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <div class="text-muted small">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $note->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-muted small mt-1">
                                        <i class="far fa-clock me-1"></i> {{ $note->created_at->format('h:i A') }}
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6 class="font-weight-bold text-muted mb-2">Note Details:</h6>
                                <p class="mb-0" style="white-space: pre-wrap; color: #4a5568; line-height: 1.6;">{{ $note->content }}</p>
                            </div>

                            <hr style="border-top: 1px solid #e2e8f0;">

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle mr-3" style="width: 40px; height: 40px; background-color: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #718096; font-weight: bold;">
                                        DR
                                    </div>
                                    <div>
                                        <div class="font-weight-bold" style="color: #2d3748;">Dr. {{ $note->doctor->name ?? 'Unknown' }}</div>
                                        <div class="small text-muted">Provider</div>
                                    </div>
                                </div>
                                @if($note->attachment_path)
                                    <a href="{{ asset('storage/' . $note->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-paperclip me-1"></i> View Attachment
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5 bg-white rounded shadow-sm">
                    <div class="mb-3">
                         <div style="width: 80px; height: 80px; background-color: #f7fafc; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file-medical text-muted fa-2x"></i>
                        </div>
                    </div>
                    <h4 class="text-muted mb-2">No Notes Found</h4>
                    <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto;">You don't have any work or school notes yet. Notes provided by your doctor during appointments will appear here.</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
