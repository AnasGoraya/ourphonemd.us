@extends('layouts.doctor')

@section('title', 'Appointment Details - OurPhoneMD')

@section('content')

<style>
	/* Page background */
	.appointment-page {
		background: #f6faf9;
		min-height: 100vh;
		padding: 32px 24px;
		box-sizing: border-box;
	}

	.appointment-container {
		max-width: 1160px;
		margin: 0 auto;
		display: grid;
		grid-template-columns: 380px 1fr;
		gap: 28px;
		align-items: start;
	}

	.card {
		background: #fff;
		border-radius: 12px;
		border: 1px solid #eef3f2;
		box-shadow: 0 6px 30px rgba(56, 93, 84, 0.06);
		overflow: hidden;
	}

	.patient-card { padding: 28px; }
	.detail-card { padding: 28px; }

	.avatar {
		width: 120px; height: 120px; border-radius: 12px; background: linear-gradient(180deg,#16a085,#1abc9c); color: #fff; display:flex; align-items:center; justify-content:center; font-size:36px; font-weight:700;
	}

	.patient-name { font-size:20px; font-weight:700; color:#0b2a27; margin-top:10px }
	.patient-meta { color:#08302c; font-size:13px; margin-top:6px }

	.info-row { display:flex; gap:12px; align-items:center; margin-top:14px }
	.info-row svg { color:currentColor }
	.info-text { color:#000; font-size:14px }

	.pill { display:inline-block; padding:6px 10px; border-radius:999px; background:#e8faf5; color:#0b2a27; font-weight:600; font-size:12px }

	.status-badge { position:absolute; right:36px; top:36px; background:#e6f6ef; color:#0b6b54; padding:8px 14px; border-radius:999px; font-weight:700; font-size:12px }

	.detail-row { display:flex; gap:18px; margin-bottom:18px }
	.detail-box { background:#fbfdfc; border-radius:10px; padding:14px; flex:1; border:1px solid #eef6f3 }
	.detail-title { color:#6b7280; font-size:12px; font-weight:700; margin-bottom:8px }
	.detail-value { color:#08302c; font-size:14px }

	.reason-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-top:18px }
	.reason-card { background:#fff; border-radius:10px; padding:12px; border:1px solid #eef3f2 }
	.reason-label { color:#6b7280; font-size:12px; font-weight:700; margin-bottom:8px }

	.actions-footer { display:flex; align-items:center; gap:12px; margin-top:22px; }
	.actions-left { display:flex; gap:10px; flex:1 }
	.actions-center { display:flex; gap:10px; justify-content:center; flex:1 }
	.actions-right { display:flex; gap:10px; justify-content:flex-end; flex:1 }

	.btn { padding:10px 16px; border-radius:8px; font-weight:700; font-size:13px; cursor:pointer; transition:all .18s ease }
	.btn-outline { background:#fff; border:1px solid #dfeeea; color:#0b6b54 }
	.btn-outline:hover { transform: translateY(-3px); box-shadow:0 8px 20px rgba(11,107,84,0.06); border-color:#bfe7d9 }
	.btn-primary { background:#06b38a; color:#fff; box-shadow:0 6px 18px rgba(6,179,138,0.18) }
	.btn-primary:hover { transform: translateY(-3px); filter:brightness(.98) }
	.btn-danger { background:#ff6161; color:#fff }
	.btn-danger:hover { transform: translateY(-3px) }

	.muted { color:#97a7a2; font-size:13px }
    
    /* Custom Modal Styles */
    .custom-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1050;
        align-items: center;
        justify-content: center;
    }
    .custom-modal-content {
        background: #fff;
        border-radius: 12px;
        width: 100%;
        max-width: 600px;
        padding: 0;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        animation: slideUp 0.3s ease-out;
    }
    .custom-modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .custom-modal-title { font-size: 18px; font-weight: 700; color: #1a2e35; margin: 0; }
    .custom-modal-close { background: none; border: none; font-size: 24px; color: #999; cursor: pointer; }
    .custom-modal-body { padding: 24px; }
    .custom-modal-footer {
        padding: 16px 24px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        background: #fcfcfc;
        border-radius: 0 0 12px 12px;
    }
    
    .form-group { margin-bottom: 16px; }
    .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px; }
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        box-sizing: border-box;
    }
    .form-control:focus { outline: none; border-color: #16a085; }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

	@media (max-width: 900px) {
		.appointment-container { grid-template-columns: 1fr; padding: 12px }
		.status-badge { position: static; margin-top: 12px }
		.reason-grid { grid-template-columns:1fr }
		.avatar { width:96px; height:96px }
	}
</style>

<div class="appointment-page">
	<div class="appointment-container">
		<!-- Left: Patient Card -->
		<div class="card patient-card" style="position:relative;">
			@php
				$isFamilyMember = $appointment->family_member_id && $appointment->familyMember;
				$person = $isFamilyMember ? $appointment->familyMember : $appointment->patient;
			@endphp

			<div style="display:flex; gap:18px; align-items:center; flex-direction:row;">
				<div class="avatar">{{ strtoupper(substr($person->first_name ?? 'P',0,1)) }}{{ strtoupper(substr($person->last_name ?? '',0,1)) }}</div>
				<div>
					<div class="patient-name">{{ ($person->first_name ?? '') }} {{ ($person->last_name ?? '') }}</div>
					<!-- Move age/gender/family member slightly below the name -->
					<div class="patient-meta" style="margin-top:8px">{{ $isFamilyMember ? 'Family Member' : 'Patient' }} • Age: {{ $person->age ?? '—' }} • {{ strtoupper($person->gender ?? '') }}</div>
				</div>
			</div>

			<!-- divider and contact info rows -->
			<hr style="border:none; border-top:1px solid #eef6f3; margin:18px 0">
			<div style="display:flex; flex-direction:column; gap:12px;">
				<div style="display:flex; align-items:center; gap:12px;">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" style="color:#06b38a"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5L4 8V6l8 5 8-5v2z"/></svg>
					<div class="info-text">{{ $person->email ?? '—' }}</div>
				</div>
				<div style="display:flex; align-items:center; gap:12px;">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" style="color:#06b38a"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.11-.21c1.21.49 2.53.76 3.88.76a1 1 0 011 1V20a1 1 0 01-1 1C10.07 21 3 13.93 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.35.27 2.67.76 3.88a1 1 0 01-.21 1.11l-2.43 2.8z"/></svg>
					<div class="info-text">{{ $person->contact_number ?? '—' }}</div>
				</div>
				<div style="display:flex; align-items:center; gap:12px;">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" style="color:#ff9aa2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg>
					<div class="info-text">{{ $person->address ?? '—' }}</div>
				</div>
			</div>

			<div style="margin-top:20px; display:flex; flex-direction:column; gap:10px">
				<a href="{{ url('doctor/patients/'.$appointment->patient_id) }}" class="btn btn-outline" style="text-align:left">View Full Profile</a>
				<a href="{{ url('doctor/patients/'.$appointment->patient_id.'/appointments') }}" class="btn btn-outline" style="text-align:left">Past Appointments</a>
				<a href="{{ url('doctor/patients/'.$appointment->patient_id.'/transactions') }}" class="btn btn-outline" style="text-align:left">Transaction History</a>
			</div>

		</div>
		<!-- Right: Details -->
		<div>
			<div class="card detail-card" style="position:relative;">
				@php
					$statusLabel = strtoupper($appointment->status ?? 'SCHEDULED');
				@endphp
				<div style="display:flex; justify-content:space-between; align-items:center;">
					<div>
						<a href="{{ route('doctor.dashboard') }}" style="color:#3aa28f; text-decoration:none; font-weight:600">← Back</a>
						<h2 style="margin:6px 0 0 0; font-size:22px; color:#08302c">Appointment Details</h2>
						<div class="muted">{{ $appointment->reason ?? 'Consultation' }}</div>
					</div>
					<div class="status-badge">{{ $statusLabel }}</div>
				</div>

				<div style="margin-top:18px;">
					<div class="detail-row">
						<div class="detail-box">
							<div class="detail-title">Appointment Date</div>
							<div class="detail-value">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F d, Y') }}</div>
						</div>
						<div class="detail-box">
							<div class="detail-title">Time</div>
							<div class="detail-value">{{ date('h:i A', strtotime($appointment->appointment_time)) }}</div>
						</div>
					</div>

					<div class="detail-row">
						<div class="detail-box">
							<div class="detail-title">Visit Type</div>
							<div class="detail-value">{{ strtoupper($appointment->type ?? 'CONSULTATION') }}</div>
						</div>
						<div class="detail-box">
							<div class="detail-title">Appointment Status</div>
							<div class="detail-value">{{ ucfirst($appointment->status) }}</div>
						</div>
					</div>

					<div style="margin-top:18px;">
						<div class="reason-grid">
							<div class="reason-card">
								<div class="reason-label">Current Issue</div>
								<div class="detail-value">{{ $appointment->reason ?? '—' }}</div>
							</div>
							<div class="reason-card">
								<div class="reason-label">Symptoms</div>
								<div class="detail-value">{{ $appointment->symptoms ?? '—' }}</div>
							</div>
						</div>

						<div style="margin-top:12px;">
							<div class="reason-card">
								<div class="reason-label">Current Medication</div>
								<div class="detail-value">{{ $appointment->current_medication ?? 'None' }}</div>
							</div>
						</div>
					</div>

					<div style="margin-top:20px;">
						<h3 style="margin:0 0 8px 0; color:#08302c;">Actions & Resources</h3>
                        <div style="background:#fff; border:1px solid #eef6f3; padding:18px; border-radius:10px; position:relative">
                            <div style="display:flex; gap:18px; align-items:flex-start; justify-content:flex-start;">
                                <!-- Column 1: Generate Note + View Details -->
                                <div style="display:flex; flex-direction:column; gap:8px; width:33%;">
                                    <div style="display:flex; gap:12px;">
                                        <button class="btn btn-outline" onclick="openNoteModal('medical')">Generate Note</button>
                                    </div>
                                    <div style="margin-top:4px;">
                                        <button class="btn btn-outline" onclick="openViewDetailsModal()" style="margin-left:4px;">View Details</button>
                                    </div>
                                </div>

                                <!-- Column 2: Attachments + Video Call -->
                                <div style="display:flex; flex-direction:column; gap:8px; width:33%;">
                                    <div style="display:flex; gap:12px;">
                                        <button class="btn btn-outline" onclick="openAttachmentsModal()">Attachments</button>
                                    </div>
                                    <div style="margin-top:4px;">
                                        <!-- Video Call Button -->
                                        @if($appointment->status !== 'completed' && $appointment->status !== 'cancelled')
                                            <button type="button" class="btn btn-primary" id="startVideoCallBtn" style="margin-left:4px;">
                                                <i class="fas fa-video me-1"></i> Video Call
                                            </button>
                                        @endif
                                    </div>
                                </div>

                    <!-- Calling Modal (Hidden by default) -->
                    <div class="modal fade" id="callingModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1060;">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content text-center">
                                <div class="modal-body py-5">
                                    <div class="mb-4">
                                        <div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem; color: #06b38a;">
                                            <span class="sr-only">Calling...</span>
                                        </div>
                                    </div>
                                    <h4 class="mb-2">Calling Patient...</h4>
                                    <p class="text-muted" id="callingStatusText">Waiting for patient to join...</p>
                                    <div class="mt-4">
                                        <button type="button" class="btn btn-danger rounded-pill px-4" id="cancelCallBtn">
                                            End Call
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                                <!-- Column 3: Work/School Note + Delete -->
                                <div style="display:flex; flex-direction:column; gap:8px; width:33%; align-items:flex-start;">
                                    <div style="display:flex; gap:12px;">
                                        <button class="btn btn-outline" onclick="openNoteModal('school')">Work/School Note</button>
                                    </div>
                                    <div style="display:flex; gap:8px;">
                                        <button class="btn btn-danger" onclick="deleteAppointment('{{ $appointment->id }}')">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
				</div>
			</div>

            <!-- Success Message Container -->
            <div id="successMessage" style="display:none; background:#e6fffa; border:1px solid #b2f5ea; color:#2c7a7b; padding:12px 16px; border-radius:8px; margin-top:16px; font-weight:600; align-items:center; gap:8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                <span>Note saved successfully!</span>
            </div>

            <!-- Past Notes Section -->
            <div class="card detail-card" style="margin-top:28px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                     <h3 style="margin:0; color:#08302c;">Past Notes & Attachments</h3>
                     
                     <!-- Small inline feedback for resend -->
                     <span id="resendSuccess" style="display:none; font-size:13px; color:#2c7a7b; background:#e6fffa; padding:4px 8px; border-radius:4px; font-weight:600;">Note resent successfully!</span>
                </div>
                
                @if(isset($pastNotes) && $pastNotes->count() > 0)
                    <div style="display:flex; flex-direction:column; gap:12px;">
                        @foreach($pastNotes as $note)
                            <div style="background:#f8fafb; padding:12px; border-radius:8px; border:1px solid #eef3f2; display:flex; justify-content:space-between; align-items:flex-start;">
                                <div style="flex:1; margin-right:12px;">
                                    <div style="font-weight:700; color:#0b2a27; font-size:14px;">
                                        {{ ucfirst($note->type) }} Note
                                        <span class="muted" style="font-weight:400; font-size:12px; margin-left:6px;">
                                            {{ $note->created_at->format('M d, Y h:i A') }}
                                        </span>
                                    </div>
                                    
                                    <!-- Note Content with Truncation -->
                                    <div class="note-content-wrapper" style="margin-top:4px;">
                                        <div class="note-text-short" id="note-short-{{ $note->id }}" style="font-size:13px; color:#4b5563; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $note->content }}
                                        </div>
                                        <div class="note-text-full" id="note-full-{{ $note->id }}" style="font-size:13px; color:#4b5563; display:none;">
                                            {{ $note->content }}
                                        </div>
                                        
                                        @if(strlen($note->content) > 100)
                                            <button onclick="toggleNote('{{ $note->id }}')" id="btn-toggle-{{ $note->id }}" style="background:none; border:none; color:#16a085; font-size:12px; font-weight:600; padding:0; margin-top:4px; cursor:pointer;">
                                                View Full Note
                                            </button>
                                        @endif
                                    </div>

                                    @if($note->attachment_path)
                                        <div style="margin-top:6px;">
                                            <a href="{{ asset('storage/'.$note->attachment_path) }}" target="_blank" style="color:#06b38a; font-size:12px; font-weight:600; text-decoration:none;">
                                                📎 View Attachment
                                            </a>
                                        </div>
                                    @endif
                                    
                                    @if($note->is_visible_to_patient)
                                        <div style="margin-top:4px; font-size:11px; color:#51A897; font-weight:600;">
                                            ✓ Sent to Payment {{ $note->sent_at ? $note->sent_at->format('M d, H:i') : '' }}
                                        </div>
                                    @endif
                                </div>
                                
                                <div style="display:flex; flex-direction:column; gap:6px; align-items:flex-end;">
                                    @if(!$note->is_visible_to_patient)
                                        <button onclick="sendNote('{{ $note->id }}')" style="background:#06b38a; border:none; color:#fff; font-size:12px; font-weight:600; cursor:pointer; padding:6px 12px; border-radius:4px;">
                                            Send to Patient
                                        </button>
                                    @else
                                        <button onclick="resendNote('{{ $note->id }}')" style="background:none; border:none; color:#3b82f6; font-size:12px; font-weight:600; cursor:pointer; white-space:nowrap;">
                                            Resend
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="muted" style="text-align:center; padding:20px;">No past notes found for this patient.</div>
                @endif
            </div>
		</div>
	</div>
</div>

<!-- COMMON NOTES MODAL (For Medical, School, Work) -->
<div id="noteModal" class="custom-modal-overlay">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title" id="noteModalTitle">Generate Note</h3>
            <button class="custom-modal-close" onclick="closeNoteModal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <form id="noteForm">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                <input type="hidden" id="noteType" name="type" value="medical">
                
                <div class="form-group">
                    <label class="form-label">Date</label>
                    <input type="text" class="form-control" value="{{ date('F d, Y') }}" readonly style="background:#f9f9f9">
                </div>
                
                <div class="form-group">
                    <label class="form-label" id="noteContentLabel">Note Content</label>
                    <textarea name="content" id="noteContent" class="form-control" rows="6" placeholder="Enter clinical notes, diagnosis, or recommendations..."></textarea>
                </div>
            </form>
        </div>
        <div class="custom-modal-footer">
            <button class="btn btn-outline" onclick="closeNoteModal()">Cancel</button>
            <button class="btn btn-primary" onclick="submitNote()">Save Note</button>
        </div>
    </div>
</div>

<!-- ATTACHMENTS MODAL -->
<div id="attachmentsModal" class="custom-modal-overlay">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">Upload Attachment</h3>
            <button class="custom-modal-close" onclick="closeAttachmentsModal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <form id="attachmentForm">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                <input type="hidden" name="type" value="general">
                <input type="hidden" name="content" value="Attachment uploaded via dashboard">
                
                <div class="form-group">
                    <label class="form-label">Select File</label>
                    <input type="file" name="attachment" id="attachmentFile" class="form-control">
                    <small class="muted" style="display:block; margin-top:4px;">Supported: PDF, JPG, PNG (Max 10MB)</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Description (Optional)</label>
                    <textarea name="content" class="form-control" rows="2" placeholder="Describe this attachment..."></textarea>
                </div>
            </form>
        </div>
        <div class="custom-modal-footer">
            <button class="btn btn-outline" onclick="closeAttachmentsModal()">Cancel</button>
            <button class="btn btn-primary" onclick="submitAttachment()">Upload</button>
        </div>
    </div>
</div>

<!-- VIEW DETAILS MODAL -->
<div id="viewDetailsModal" class="custom-modal-overlay">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">Appointment Summary</h3>
            <button class="custom-modal-close" onclick="closeViewDetailsModal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <div style="background:#f8f9fa; padding:16px; border-radius:8px;">
                <p><strong>Patient:</strong> {{ $person->first_name }} {{ $person->last_name }}</p>
                <p><strong>Doctor:</strong> Dr. {{ Auth::user()->name }}</p>
                <p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
                <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
                <hr style="margin:12px 0; border:0; border-top:1px solid #ddd;">
                <p><strong>Reason:</strong> {{ $appointment->reason }}</p>
                <p><strong>Symptoms:</strong> {{ $appointment->symptoms }}</p>
            </div>
        </div>
        <div class="custom-modal-footer">
            <button class="btn btn-outline" onclick="closeViewDetailsModal()">Close</button>
            <button class="btn btn-primary" onclick="window.print()">Print Summary</button>
        </div>
    </div>
</div>
<script>
    // Note Modal Types
    const NOTE_TEMPLATES = {
        'medical': "Patient presented with...\n\nDiagnosis:\n\nPlan:",
        'school': "To Whom It May Concern,\n\nPlease excuse {{ $person->first_name }} from school on {{ date('F d, Y') }} due to medical appointment.\n\nSincerely,\nDr. {{ Auth::user()->name }}",
        'work': "To Whom It May Concern,\n\nPlease excuse {{ $person->first_name }} from work on {{ date('F d, Y') }} due to medical reasons.\n\nSincerely,\nDr. {{ Auth::user()->name }}"
    };

	function startVideoCall(id){
		alert('Starting secure video call session for appointment #' + id + '...');
	}
    
    function deleteAppointment(id){ 
        if(confirm('Are you sure you want to delete this appointment? This action cannot be undone.')){
             const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/doctor/cancel-appointment/' + id;
            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = '{{ csrf_token() }}';
            form.appendChild(token);
            document.body.appendChild(form);
            form.submit();
        } 
    }

    // Modal Functions
    function openNoteModal(type) {
        document.getElementById('noteType').value = type;
        document.getElementById('noteModalTitle').innerText = type === 'medical' ? 'Generate Medical Note' : (type === 'school' ? 'Work/School Note' : 'Generate Note');
        
        const contentArea = document.getElementById('noteContent');
        if(!contentArea.value || confirm('Replace current content with template?')) {
            contentArea.value = NOTE_TEMPLATES[type] || '';
        }
        
        document.getElementById('noteModal').style.display = 'flex';
    }

    function closeNoteModal() {
        document.getElementById('noteModal').style.display = 'none';
        document.getElementById('noteContent').value = ''; 
    }

    function openAttachmentsModal() {
        document.getElementById('attachmentsModal').style.display = 'flex';
    }

    function closeAttachmentsModal() {
        document.getElementById('attachmentsModal').style.display = 'none';
        document.getElementById('attachmentFile').value = '';
    }

    function openViewDetailsModal() {
        document.getElementById('viewDetailsModal').style.display = 'flex';
    }

    function closeViewDetailsModal() {
        document.getElementById('viewDetailsModal').style.display = 'none';
    }

    function showSuccessMessage(msg, type = 'main') {
        if(type === 'resend') {
            const el = document.getElementById('resendSuccess');
            el.innerText = msg;
            el.style.display = 'inline-block';
            setTimeout(() => { el.style.display = 'none'; }, 3000);
        } else {
            const el = document.getElementById('successMessage');
            el.querySelector('span').innerText = msg;
            el.style.display = 'flex';
            // Scroll to the message if needed, or just show it
            setTimeout(() => { 
                el.style.display = 'none';
                // Reload to show the new note in the list
                window.location.reload(); 
            }, 1500);
        }
    }

    function toggleNote(id) {
        const shortText = document.getElementById('note-short-' + id);
        const fullText = document.getElementById('note-full-' + id);
        const btn = document.getElementById('btn-toggle-' + id);
        
        if (shortText.style.display === 'none') {
            shortText.style.display = '-webkit-box';
            fullText.style.display = 'none';
            btn.innerText = 'View Full Note';
        } else {
            shortText.style.display = 'none';
            fullText.style.display = 'block';
            btn.innerText = 'Show Less';
        }
    }

    function submitNote() {
        const form = document.getElementById('noteForm');
        const formData = new FormData(form);
        
        fetch('{{ route("doctor.notes.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
             if (!response.ok) { return response.text().then(text => { throw new Error(text) }); }
             return response.json();
        })
        .then(data => {
            if(data.success) {
                closeNoteModal();
                showSuccessMessage('Note saved successfully!');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Check console for details.\n' + error.message.substring(0, 100));
        });
    }

    function submitAttachment() {
        const form = document.getElementById('attachmentForm');
        const formData = new FormData(form);
        
        if(!document.getElementById('attachmentFile').files.length){
            alert('Please select a file.');
            return;
        }

        fetch('{{ route("doctor.notes.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
             if (!response.ok) { return response.text().then(text => { throw new Error(text) }); }
             return response.json();
        })
        .then(data => {
            if(data.success) {
                closeAttachmentsModal();
                showSuccessMessage('Attachment uploaded successfully!');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Check console for details.\n' + error.message.substring(0, 100));
        });
    }

    function sendNote(noteId) {
        if(!confirm('Send this note/attachment to the patient? They will be able to view it on their dashboard.')) return;

        fetch('/doctor/notes/' + noteId + '/resend', { // Reusing resend endpoint which toggles visibility
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showSuccessMessage('Sent to patient successfully!');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    }

    function resendNote(noteId) {
        if(!confirm('Resend this note to the patient via email?')) return;

        fetch('/doctor/notes/' + noteId + '/resend', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showSuccessMessage('Note resent successfully!', 'resend');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startBtn = document.getElementById('startVideoCallBtn');
        const callingModal = new bootstrap.Modal(document.getElementById('callingModal'));
        const cancelBtn = document.getElementById('cancelCallBtn');
        let currentCallId = null;

        if (startBtn) {
            startBtn.addEventListener('click', function() {
                // Show modal
                callingModal.show();
                
                // Call API to start
                fetch('{{ route('video.start') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        patient_id: {{ $appointment->patient_id }},
                        appointment_id: {{ $appointment->id }}
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentCallId = data.call_id;
                        console.log('Call started, ID:', currentCallId);
                        // In a real app, you might join the room immediately or wait for the patient
                        // For this demo, we auto-redirect to the room URL after a short delay or user action
                       
                        // Simulate opening video room (since we don't have a real provide UI yet)
                         setTimeout(() => {
                             window.open(data.room_url || 'https://meet.jit.si/' + data.room_name, '_blank');
                             // callingModal.hide(); // Optional: keep open or hide
                         }, 2000);
                    } else {
                        alert('Failed to start call');
                        callingModal.hide();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error starting call');
                    callingModal.hide();
                });
            });
        }

        cancelBtn.addEventListener('click', function() {
            if (currentCallId) {
                // Call API to end/cancel
                fetch(`/video/${currentCallId}/end`, {
                    method: 'POST',
                     headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
            }
            callingModal.hide();
        });
    });
</script>

@endsection
