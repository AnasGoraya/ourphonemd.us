@extends('layouts.patient')

@section('page_title', 'My Appointments')

@section('content')
<div id="dashboardContent" class="flex-1 p-4 lg:ml-0" style="background-color: #f9fafb;">
    <div class="w-full max-w-7xl mx-auto px-4 py-6">
        @if(session('success') || session('status'))
            <div class="alert alert-success alert-dismissible show border-0 mb-4" role="alert" style="background-color: #ecfdf5; border-left: 5px solid #10b981; border-radius: 12px; color: #064e3b; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: block !important;">
                <div class="d-flex align-items-center">
                    <svg class="mr-3" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span>{{ session('success') ?? session('status') }}</span>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="opacity: 0.5;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 mb-4" role="alert" style="background-color: #fef2f2; border-left: 5px solid #ef4444; border-radius: 12px; color: #7f1d1d; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div class="d-flex align-items-start">
                    <svg class="mr-3 mt-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <ul class="mb-0 list-unstyled">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="opacity: 0.5;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900" style="font-size: 30px; font-weight: 700; color: #111827;">My Appointments</h1>
            <p class="text-gray-500 mt-2" style="color: #6b7280; font-size: 14px;">Manage your healthcare appointments</p>
        </div>

        <!-- Appointment Management Cards -->
        <div class="mb-5">
            <div class="row g-4">
                <!-- Schedule Appointment Card -->
                <div class="col-md-6">
                    <div class="h-100 p-4 rounded-lg shadow-sm bg-white border" style="border-radius: 20px !important; border: 1px solid #eef0f3 !important; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="p-3" style="background-color: rgba(81, 168, 151, 0.1); border-radius: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#51A897" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path><path d="M12 14v4"></path><path d="M10 16h4"></path>
                                </svg>
                            </div>
                            <div class="text-muted opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10"></line>
                                </svg>
                            </div>
                        </div>
                        <div class="px-1">
                            <h3 class="h5 font-weight-bold text-dark mb-2">Schedule New Appointment</h3>
                            <p class="text-muted small mb-4" style="line-height: 1.6;">Book a new appointment with available healthcare providers in just a few clicks.</p>
                            <a href="{{ route('patient.appointments.wizard.step1') }}" class="btn w-100 py-3 font-weight-bold" style="background-color: #51A897 !important; color: white !important; border-radius: 12px; border: none; font-size: 16px;">
                                Book Now &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                <!-- View Calendar Card -->
                <div class="col-md-6">
                    <div class="h-100 p-4 rounded-lg shadow-sm bg-white border" style="border-radius: 20px !important; border: 1px solid #eef0f3 !important; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="p-3" style="background-color: rgba(81, 168, 151, 0.1); border-radius: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#51A897" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5"></path><path d="M16 2v4"></path><path d="M8 2v4"></path><path d="M3 10h5"></path><path d="M17.5 17.5 16 16.3V14"></path><circle cx="16" cy="16" r="6"></circle>
                                </svg>
                            </div>
                            <div class="text-muted opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 2v4"></path><path d="M16 2v4"></path><path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"></path><path d="M3 10h18"></path><path d="M16 19h6"></path><path d="M19 16v6"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="px-1">
                            <h3 class="h5 font-weight-bold text-dark mb-2">View Calendar</h3>
                            <p class="text-muted small mb-4" style="line-height: 1.6;">View and manage all your scheduled appointments on an interactive calendar view.</p>
                            <button onclick="showCalendarView()" class="btn w-100 py-3 font-weight-bold" style="background-color: #51A897 !important; color: white !important; border-radius: 12px; border: none; font-size: 16px;">
                                Open Calendar &rarr;
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments Section -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold" style="font-weight: 600; font-size: 20px; color: #111827;">Upcoming Appointments</h2>
            </div>

            @forelse($appointments as $appointment)
                @php
                    $appointmentFor = $appointment->patient->first_name;
                    $appointmentBadgeBg = '#FFEDD5'; // Light orange for self appointments
                    $appointmentBadgeColor = '#9A3412'; // Dark orange for text

                    if ($appointment->family_member_id && $appointment->familyMember) {
                        $appointmentFor = $appointment->familyMember->first_name;
                        // Color code by family member type
                        $familyMemberType = $appointment->familyMember->relationship ?? 'member';
                        if (stripos($familyMemberType, 'parent') !== false) {
                            $appointmentBadgeBg = '#E0E7FF'; // Indigo for parents
                            $appointmentBadgeColor = '#3730A3';
                        } elseif (stripos($familyMemberType, 'spouse') !== false) {
                            $appointmentBadgeBg = '#FCE7F3'; // Pink for spouse
                            $appointmentBadgeColor = '#831843';
                        } elseif (stripos($familyMemberType, 'child') !== false) {
                            $appointmentBadgeBg = '#DCFCE7'; // Green for children
                            $appointmentBadgeColor = '#15803D';
                        } elseif (stripos($familyMemberType, 'sibling') !== false) {
                            $appointmentBadgeBg = '#FEF08A'; // Yellow for siblings
                            $appointmentBadgeColor = '#713F12';
                        }
                    }

                    $statusText = 'Scheduled';
                    $statusBg = '#DBEAFE';
                    $statusColor = '#1E40AF';

                    if ($appointment->status == 'in_progress') {
                        $statusText = 'In Progress';
                        $statusBg = '#f97316';
                        $statusColor = 'white';
                    } elseif ($appointment->status == 'scheduled') {
                        $statusText = 'Scheduled';
                        $statusBg = '#DBEAFE';
                        $statusColor = '#1E40AF';
                    } elseif ($appointment->status == 'confirmed') {
                        $statusText = 'Confirmed';
                        $statusBg = '#dbeafe';
                        $statusColor = '#1e40af';
                    } elseif ($appointment->payment && $appointment->payment->status !== 'succeeded') {
                        $statusText = 'Pending Payment';
                        $statusBg = '#FBBF24';
                        $statusColor = 'black';
                    } elseif ($appointment->status == 'pending') {
                        $statusText = 'Pending Confirmation';
                        $statusBg = '#FEF3C7';
                        $statusColor = '#92400E';
                    }
                @endphp

                <!-- Appointment Number Badge -->
                <div class="flex items-center gap-3 mb-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold text-sm" style="background-color: {{ $appointmentBadgeBg }}; color: {{ $appointmentBadgeColor }}; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">
                        {{ $loop->iteration }}
                    </span>
                    <span class="text-xs font-semibold text-gray-600">Appointment {{ $loop->iteration }}</span>
                </div>

                <div class="rounded-xl border border-gray-100 bg-white shadow-sm hover:shadow-md hover:border-[#51A897]/30 transition-all duration-300 overflow-hidden mb-4" style="border-radius: 12px; border: 1px solid #e5e7eb; background-color: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); cursor: pointer;" onclick="viewAppointmentDetails('{{ route('patient.appointment.details', $appointment->token) }}')">
                    <!-- Status Bar -->
                    <div class="px-5 py-3 border-b border-gray-50 flex justify-between items-center bg-gray-50/50" style="background-color: #f9fafb; display: flex; justify-content: space-between; align-items: center;">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full" style="width: 8px; height: 8px; background-color: #51A897; border-radius: 50%;"></span>
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                {{ $appointment->appointment_mode == 'telemedicine' ? 'Virtual Consultation' : 'In-Person Visit' }}
                            </span>
                        </div>
                        <span class="px-2.5 py-1 text-[10px] rounded-lg font-bold shadow-sm" style="padding: 6px 10px; font-size: 10px; border-radius: 6px; font-weight: 600; background-color: {{ $statusBg }}; color: {{ $statusColor }};">
                            {{ $statusText }}
                        </span>
                    </div>

                    <div class="p-6" style="padding: 24px;">
                        <!-- Doctor Info -->
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-xl bg-[#51A897]/10 flex items-center justify-center text-[#51A897] group-hover:bg-[#51A897] group-hover:text-white transition-all duration-300 shadow-sm border border-[#51A897]/20" style="width: 48px; height: 48px; background-color: rgba(81, 168, 151, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #51A897; border: 1px solid rgba(81, 168, 151, 0.2);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-gray-900" style="font-size: 16px; font-weight: 700; color: #111827;">Dr. {{ $appointment->doctor->name ?? 'Healthcare Provider' }}</h4>
                                <p class="text-xs text-gray-500 font-medium">Healthcare Specialist</p>
                            </div>
                        </div>

                        <hr style="border: none; border-top: 1px solid #f3f4f6; margin: 16px 0;">

                        <!-- Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px;">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-[#51A897]" style="width: 32px; height: 32px; background-color: #f9fafb; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #51A897;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10"></line></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase leading-none mb-1">Date & Time</p>
                                    <p class="text-sm font-bold text-gray-800" style="font-size: 14px; font-weight: 700; color: #1f2937;">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('D, M j, Y') }} | {{ date('h:i A', strtotime($appointment->appointment_time)) }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-[#51A897]" style="width: 32px; height: 32px; background-color: #f9fafb; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #51A897;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase leading-none mb-1">Patient</p>
                                    <p class="text-sm font-bold text-gray-800" style="font-size: 14px; font-weight: 700; color: #1f2937;">{{ $appointmentFor }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-[#51A897]" style="width: 32px; height: 32px; background-color: #f9fafb; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #51A897;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase leading-none mb-1">Type</p>
                                    <p class="text-sm font-bold text-gray-800" style="font-size: 14px; font-weight: 700; color: #1f2937;">{{ ucfirst($appointment->appointment_type ?? 'Consultation') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-[#51A897]" style="width: 32px; height: 32px; background-color: #f9fafb; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #51A897;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase leading-none mb-1">Method</p>
                                    <p class="text-sm font-bold text-gray-800" style="font-size: 14px; font-weight: 700; color: #1f2937;">
                                        {{ $appointment->appointment_mode == 'telemedicine' ? 'Video Call' : 'In-Person' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Health Issues Section -->
                        @if($appointment->reason || $appointment->symptoms || $appointment->allergies)
                        <div style="margin-top: 16px;">
                            <p class="text-xs font-bold text-gray-500 uppercase mb-2">Health Information</p>
                            <div class="text-sm text-gray-700" style="font-size: 14px; color: #374151;">
                                @if($appointment->reason)
                                    <p><strong>Reason:</strong> {{ $appointment->reason }}</p>
                                @endif
                                @if($appointment->symptoms)
                                    <p><strong>Symptoms:</strong> {{ $appointment->symptoms }}</p>
                                @endif
                                @if($appointment->allergies)
                                    <p><strong>Allergies:</strong> {{ $appointment->allergies }}</p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Footer Actions -->
                    <div class="px-6 py-4 bg-gray-50/80 border-t border-gray-100 flex items-center justify-between gap-3" style="background-color: #f9fafb; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; gap: 12px;">
                        <button onclick="viewAppointmentDetails('{{ route('patient.appointment.details', $appointment->token) }}')" class="flex-1 py-2.5 px-4 text-sm font-bold bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-100 transition-all duration-200" style="flex: 1; padding: 10px 16px; font-size: 14px; font-weight: 700; background-color: white; border: 1px solid #e5e7eb; color: #374151; border-radius: 8px; cursor: pointer;">
                            View Details
                        </button>

                        @if($appointment->payment && $appointment->payment->status !== 'succeeded')
                            <a href="{{ route('patient.appointments.pay', $appointment->id) }}" class="flex-1 py-2.5 px-4 text-sm font-bold bg-[#51A897] text-white rounded-xl hover:bg-[#439686] transition-all duration-200 text-center" style="flex: 1; padding: 10px 16px; font-size: 14px; font-weight: 700; background-color: #51A897; color: white; border-radius: 8px; text-decoration: none;">
                                Pay Now
                            </a>
                        @else
                            <button disabled class="flex-1 py-2.5 px-4 text-sm font-bold bg-gray-100 text-gray-400 rounded-xl cursor-not-allowed" style="flex: 1; padding: 10px 16px; font-size: 14px; font-weight: 700; background-color: #f3f4f6; color: #9ca3af; border-radius: 8px; cursor: not-allowed;">
                                Scheduled
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="rounded-xl border bg-white shadow-sm p-6 py-8 text-center mt-4" style="border-radius: 12px; border: 1px solid #e5e7eb; background-color: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); padding: 24px; text-align: center;">
                    <div class="d-flex flex-column align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar mb-3 text-gray-300" style="margin-bottom: 12px; color: #d1d5db;">
                            <path d="M8 2v4"></path>
                            <path d="M16 2v4"></path>
                            <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                            <path d="M3 10h18"></path>
                        </svg>
                        <h3 class="h5 font-weight-bold mb-1 text-customTeal">No Upcoming Appointments</h3>
                        <p class="text-muted mb-4">You don't have any scheduled appointments at the moment.</p>
                        <a href="{{ route('patient.appointments.wizard.step1') }}" class="btn btn-primary">
                            Schedule Now
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Calendar View -->
<div id="calendarContent" style="display: none;" class="flex-1 p-4 lg:ml-0">
    <div class="w-full px-0 py-6 md:max-w-7xl md:mx-auto md:px-2 lg:px-8">
        <div class="mb-8">
            <h1 class="h3 font-weight-bold mb-1" style="color: #000000 !important; font-size: 30px;">My Appointments - Calendar</h1>
            <p class="text-muted" style="font-size: 1.05rem;">View, schedule and manage your healthcare appointments</p>
        </div>
        <div class="mb-8">
            <button type="button" class="btn btn-outline-secondary mb-3" onclick="showDashboard()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2" style="display: inline;">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Back to Appointments
            </button>
        </div>
        <div class="calendar-full-page">
            <div class="calendar-header mb-4">
                <div>
                    <button class="btn btn-outline-secondary btn-sm" onclick="previousMonth()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6"/>
                        </svg>
                    </button>
                    <span id="calendarTitle" style="margin: 0 20px; font-size: 20px; font-weight: 600;"></span>
                    <button class="btn btn-outline-secondary btn-sm" onclick="nextMonth()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6"/>
                        </svg>
                    </button>
                    <button class="btn btn-secondary btn-sm" onclick="today()">Today</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="calendarGrid" class="calendar-grid"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .action-btn {
        background-color: #51A897;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
        text-decoration: none;
    }

    .action-btn:hover {
        background-color: #439686;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .action-btn.secondary {
        background-color: white;
        color: #51A897;
        border: 2px solid #51A897;
    }

    .action-btn.secondary:hover {
        background-color: #f9fafb;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        margin-bottom: 20px;
    }

    .weekday-header {
        text-align: center;
        font-weight: bold;
        color: rgb(87, 165, 150);
        padding: 10px;
        font-size: 14px;
        text-transform: uppercase;
    }

    .calendar-day {
        aspect-ratio: 0.8;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        background-color: #fff;
        transition: all 0.2s;
        position: relative;
        flex-direction: column;
        padding-top: 5px;
    }

    .calendar-day:hover:not(.empty):not(.other-month) {
        border-color: rgb(87, 165, 150);
        box-shadow: 0 0 0 2px rgba(87, 165, 150, 0.1);
    }

    .calendar-day-number {
        position: absolute;
        top: 5px;
        right: 8px;
        font-size: 12px;
        color: #9CA3AF;
    }

    .apt-entry {
        font-size: 10px;
        padding: 2px 4px;
        margin: 1px 2px;
        border-radius: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: calc(100% - 4px);
        text-align: center;
        font-weight: 600;
        cursor: pointer;
        z-index: 10;
    }

    .apt-self { background-color: #FFEDD5; color: #9A3412; border: 1px solid #FED7AA; }
    .apt-parent { background-color: #DBEAFE; color: #1E40AF; border: 1px solid #BFDBFE; }
    .apt-sibling { background-color: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; }
    .apt-child { background-color: #F3E8FF; color: #6B21A8; border: 1px solid #E9D5FF; }
    .apt-default { background-color: #F3F4F6; color: #374151; border: 1px solid #D1D5DB; }

    .calendar-day.empty,
    .calendar-day.other-month {
        background-color: #f9fafb;
        cursor: not-allowed;
        color: #d1d5db;
    }

    .calendar-day.has-appointment {
        background-color: #f0fdf4;
        border-color: #86efac;
    }

    .calendar-day.today {
        border: 2px solid #51A897;
        background-color: #f0fdf4;
    }

    .appointments-list {
        background-color: white;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        padding: 20px;
    }

    .appointment-item {
        padding: 12px;
        border-left: 4px solid rgb(87, 165, 150);
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 12px;
        background-color: #f9fafb;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .appointment-item:hover {
        background-color: #f0fdf4;
    }

    .appointment-details {
        flex: 1;
    }

    .appointment-details strong {
        color: #111827;
        display: block;
        margin-bottom: 4px;
    }

    .appointment-details small {
        color: #6b7280;
        display: block;
    }

    .appointment-status {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        margin-left: 10px;
    }

    .appointment-status.confirmed {
        background-color: #dcfce7;
        color: #166534;
    }

    .appointment-status.pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .appointment-status.cancelled {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .no-appointments-message {
        text-align: center;
        padding: 40px 20px;
        color: #6b7280;
    }

    .no-appointments-message svg {
        width: 48px;
        height: 48px;
        margin-bottom: 10px;
        color: #d1d5db;
    }
</style>

<script>
    const allAppointments = {!! json_encode($appointments) !!};
    const appointmentsByDate = {};

    // Group appointments by date
    allAppointments.forEach(apt => {
        const date = apt.appointment_date;
        if (!appointmentsByDate[date]) {
            appointmentsByDate[date] = [];
        }
        const appointmentType = apt.family_member_id ? 'family' : 'self';
        appointmentsByDate[date].push({
            ...apt,
            appointmentType: appointmentType
        });
    });

    let currentDate = new Date();

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        const monthName = new Date(year, month).toLocaleString('default', { month: 'long', year: 'numeric' });
        document.getElementById('calendarTitle').textContent = monthName;

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();

        const calendarGrid = document.getElementById('calendarGrid');
        calendarGrid.innerHTML = '';

        const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        weekdays.forEach(day => {
            const dayHeader = document.createElement('div');
            dayHeader.className = 'weekday-header';
            dayHeader.textContent = day;
            calendarGrid.appendChild(dayHeader);
        });

        for (let i = firstDay - 1; i >= 0; i--) {
            const day = document.createElement('div');
            day.className = 'calendar-day other-month empty';
            day.textContent = daysInPrevMonth - i;
            calendarGrid.appendChild(day);
        }

        const today = new Date();
        for (let i = 1; i <= daysInMonth; i++) {
            const day = document.createElement('div');
            day.className = 'calendar-day';
            day.style.display = 'flex';
            day.style.flexDirection = 'column';
            day.style.justifyContent = 'flex-start';
            day.style.paddingTop = '20px';

            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === i;
            const appointments = appointmentsByDate[dateStr];

            if (isToday) {
                day.classList.add('today');
            }

            const dayNum = document.createElement('span');
            dayNum.className = 'calendar-day-number';
            dayNum.textContent = i;
            day.appendChild(dayNum);

            if (appointments && appointments.length > 0) {
                day.classList.add('has-appointment');
                appointments.forEach(apt => {
                    const aptEl = document.createElement('div');
                    const rel = apt.family_member_id ? (apt.family_member?.relationship?.toLowerCase() || 'default') : 'self';
                    aptEl.className = `apt-entry apt-${rel}`;
                    aptEl.textContent = apt.family_member_id ? apt.family_member.first_name : (apt.patient?.first_name || 'Self');
                    aptEl.onclick = (e) => {
                        e.stopPropagation();
                        viewAppointmentDetails(
                            `{{ url('patient/appointments') }}/${apt.token}`
                        );
                    };
                    day.appendChild(aptEl);
                });
            }

            day.onclick = () => showAppointmentsForDate(dateStr);
            calendarGrid.appendChild(day);
        }

        const totalCells = calendarGrid.children.length - 7;
        const remainingCells = 42 - totalCells;
        for (let i = 1; i <= remainingCells; i++) {
            const day = document.createElement('div');
            day.className = 'calendar-day other-month empty';
            day.innerHTML = `<span class="calendar-day-number">${i}</span>`;
            calendarGrid.appendChild(day);
        }

        const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
        // Don't show appointments list on calendar
    }

    function showAppointmentsForDate(dateStr) {
        // Simplified: Just navigate to first appointment of the day
        const appointments = appointmentsByDate[dateStr] || [];
        if (appointments.length > 0) {
            viewAppointmentDetails(
                `{{ url('patient/appointments') }}/${appointments[0].token}`
            );
        }
    }

    function nextMonth() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    }

    function previousMonth() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    }

    function today() {
        currentDate = new Date();
        renderCalendar();
    }

    function showCalendarView() {
        document.getElementById('dashboardContent').style.display = 'none';
        document.getElementById('calendarContent').style.display = 'block';
        renderCalendar();
    }

    function showDashboard() {
        document.getElementById('calendarContent').style.display = 'none';
        document.getElementById('dashboardContent').style.display = 'block';
    }

    function viewAppointmentDetails(url) {
        window.location.href = url;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize on page load
    });
</script>
@endsection
