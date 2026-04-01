@extends('layouts.patient')

@section('page_title', 'Appointment Details')

@section('content')

<style>
    @media (min-width: 1024px) {
        .appointment-details-grid {
            grid-template-columns: 2fr 1fr !important;
        }
    }

    @media (max-width: 1023px) {
        .appointment-details-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<div class="flex-1 p-4 lg:ml-0" style="background-color: #f9fafb;">
    <div class="w-full max-w-7xl mx-auto px-4 py-6">
        <div class="mb-6">
            <a class="flex items-center text-gray-600 hover:text-customTeal mb-4" href="{{ route('patient.appointment.dashboard') }}" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: #6b7280; transition: color 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left" style="width: 16px; height: 16px;">
                    <path d="m12 19-7-7 7-7"></path>
                    <path d="M19 12H5"></path>
                </svg>
                Back to Appointments
            </a>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900" style="font-size: 30px; font-weight: 700; color: #111827; margin-bottom: 8px;">Appointment Details</h1>
                    <p class="text-gray-500 mt-1" style="color: #6b7280; font-size: 14px;">{{ $appointment->reason ?? 'Consultation' }}</p>
                </div>
                <div class="flex items-center gap-3">
                    @php
                        $badgeBg = '#DBEAFE';
                        $badgeColor = '#1E40AF';
                        $label = ucfirst($appointment->status ?? 'scheduled');
                        if ($appointment->status == 'in_progress') {
                            $badgeBg = '#f97316';
                            $badgeColor = 'white';
                            $label = 'In Progress';
                        } elseif ($appointment->status == 'scheduled') {
                            $badgeBg = '#DBEAFE';
                            $badgeColor = '#1E40AF';
                            $label = 'Scheduled';
                        } elseif ($appointment->status == 'confirmed') {
                            $badgeBg = '#dbeafe';
                            $badgeColor = '#1e40af';
                            $label = 'Confirmed';
                        }
                    @endphp
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold" style="background-color: {{ $badgeBg }}; color: {{ $badgeColor }}; border-radius: 9999px; padding: 4px 12px; font-size: 11px; font-weight: 600;">{{ $label }}</span>
                </div>
            </div>
        </div>

        @if(isset($appointment))
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" style="display: grid; grid-template-columns: 1fr; gap: 24px;">
            <style>
                @media (min-width: 1024px) {
                    .appointment-details-grid {
                        grid-template-columns: 2fr 1fr !important;
                    }
                }
            </style>

            <div class="appointment-details-grid" style="display: grid; grid-template-columns: 1fr; gap: 24px;">
                <div class="space-y-6" style="display: flex; flex-direction: column; gap: 24px;">
                <!-- Patient Information Card -->
                <div class="rounded-xl border bg-white shadow" style="border-radius: 12px; border: 1px solid #e5e7eb; background-color: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
                    <div class="p-6" style="padding: 24px;">
                        @php
                            // Check if this is a family member appointment
                            $isFamilyMember = $appointment->family_member_id && $appointment->familyMember;
                            $appointmentPerson = $isFamilyMember ? $appointment->familyMember : $appointment->patient;
                            $personType = $isFamilyMember ? 'Family Member' : 'Patient';
                            $relationship = $isFamilyMember ? $appointment->familyMember->relationship : null;
                        @endphp
                        <div class="font-semibold leading-none tracking-tight flex items-center gap-2 mb-4" style="font-weight: 600; display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px; color: #57a596;">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            {{ $isFamilyMember ? 'Family Member Information' : 'Patient Information' }}
                        </div>
                        <div class="flex items-start gap-4" style="display: flex; align-items: flex-start; gap: 16px;">
                            <span class="relative flex shrink-0 overflow-hidden rounded-full" style="width: 64px; height: 64px; border-radius: 9999px; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 600; color: #57a596;">
                                {{ strtoupper(substr($appointmentPerson->first_name ?? 'A', 0, 1)) }}{{ strtoupper(substr($appointmentPerson->last_name ?? 'N', 0, 1)) }}
                            </span>
                            <div class="flex-1 space-y-3" style="flex: 1; display: flex; flex-direction: column; gap: 12px;">
                                <div>
                                    <h3 class="text-lg font-semibold" style="font-size: 18px; font-weight: 600; color: #111827;">{{ $appointmentPerson->first_name ?? '' }} {{ $appointmentPerson->last_name ?? '' }}</h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <p class="text-gray-600" style="color: #6b7280; font-size: 14px;">{{ $personType }}</p>
                                        @if($isFamilyMember && $relationship)
                                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full" style="background-color: #e0e7ff; color: #3730a3; padding: 4px 8px; border-radius: 9999px; font-size: 11px; font-weight: 600; text-transform: capitalize;">{{ $relationship }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px;">
                                    <div class="flex items-center gap-2" style="display: flex; align-items: center; gap: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #9ca3af;">
                                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                        </svg>
                                        <span class="text-sm text-gray-600" style="font-size: 14px; color: #6b7280;">{{ $appointmentPerson->email ?? '' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2" style="display: flex; align-items: center; gap: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #9ca3af;">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                        </svg>
                                        <span class="text-sm text-gray-600" style="font-size: 14px; color: #6b7280;">{{ $appointmentPerson->contact_number ?? '+1 (387) 382 7578' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2" style="display: flex; align-items: center; gap: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #9ca3af;">
                                            <path d="M8 2v4"></path>
                                            <path d="M16 2v4"></path>
                                            <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                            <path d="M3 10h18"></path>
                                        </svg>
                                        <span class="text-sm text-gray-600" style="font-size: 14px; color: #6b7280;">DOB: {{ $appointmentPerson->date_of_birth ?? 'Sep 2, 2003' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2" style="display: flex; align-items: center; gap: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #9ca3af;">
                                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span class="text-sm text-gray-600 capitalize" style="font-size: 14px; color: #6b7280; text-transform: capitalize;">{{ $appointmentPerson->gender ?? 'Male' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appointment Information Card -->
                <div class="rounded-xl border bg-white shadow" style="border-radius: 12px; border: 1px solid #e5e7eb; background-color: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
                    <div class="p-6" style="padding: 24px;">
                        <div class="font-semibold leading-none tracking-tight flex items-center gap-2 mb-4" style="font-weight: 600; display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px; color: #57a596;">
                                <path d="M8 2v4"></path>
                                <path d="M16 2v4"></path>
                                <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                <path d="M3 10h18"></path>
                            </svg>
                            Appointment Information
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px;">
                            <div class="flex items-center gap-3" style="display: flex; align-items: center; gap: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #6b7280;">
                                    <path d="M8 2v4"></path>
                                    <path d="M16 2v4"></path>
                                    <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                    <path d="M3 10h18"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500" style="font-size: 12px; color: #9ca3af;">Date</p>
                                    <p class="font-medium" style="font-weight: 500; color: #111827;">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3" style="display: flex; align-items: center; gap: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #6b7280;">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500" style="font-size: 12px; color: #9ca3af;">Time</p>
                                    <p class="font-medium" style="font-weight: 500; color: #111827;">{{ date('h:i A', strtotime($appointment->appointment_time)) }} - {{ date('h:i A', strtotime($appointment->appointment_time) + 1200) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3" style="display: flex; align-items: center; gap: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #6b7280;">
                                    <path d="M11 2v2"></path>
                                    <path d="M5 2v2"></path>
                                    <path d="M5 3H4a2 2 0 0 0-2 2v4a6 6 0 0 0 12 0V5a2 2 0 0 0-2-2h-1"></path>
                                    <path d="M8 15a6 6 0 0 0 12 0v-3"></path>
                                    <circle cx="20" cy="10" r="2"></circle>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500" style="font-size: 12px; color: #9ca3af;">Type</p>
                                    <p class="font-medium" style="font-weight: 500; color: #111827; text-transform: uppercase;">{{ $appointment->type ?? 'CONSULTATION' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3" style="display: flex; align-items: center; gap: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #57a596;">
                                    <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path>
                                    <rect x="2" y="6" width="14" height="12" rx="2"></rect>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500" style="font-size: 12px; color: #9ca3af;">Method</p>
                                    <p class="font-medium" style="font-weight: 500; color: #111827;">{{ $appointment->method ?? 'Video Call' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Health Issues Card -->
                <div class="rounded-xl border bg-white shadow" style="border-radius: 12px; border: 1px solid #e5e7eb; background-color: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
                    <div class="p-6" style="padding: 24px;">
                        <div class="font-semibold leading-none tracking-tight flex items-center gap-2 mb-4" style="font-weight: 600; display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px; color: #57a596;">
                                <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                <path d="M12 11h4"></path>
                                <path d="M12 16h4"></path>
                                <path d="M8 11h.01"></path>
                                <path d="M8 16h.01"></path>
                            </svg>
                            Health Issues
                        </div>
                        <div class="space-y-4" style="display: flex; flex-direction: column; gap: 16px;">
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-1" style="font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Reason for Appointment</p>
                                <p class="text-gray-900" style="color: #111827; font-size: 14px;">{{ $appointment->reason ?? 'hhiu' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-1" style="font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Symptoms</p>
                                <p class="text-gray-900 whitespace-pre-wrap" style="color: #111827; font-size: 14px;">{{ $appointment->symptoms ?? 'yruy' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-1" style="font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 4px;">Allergies</p>
                                <p class="text-gray-900 whitespace-pre-wrap" style="color: #111827; font-size: 14px;">{{ $appointment->allergies ?? 'tet' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Healthcare Provider Card -->
                <div class="rounded-xl border bg-white shadow" style="border-radius: 12px; border: 1px solid #e5e7eb; background-color: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
                    <div class="p-6" style="padding: 24px;">
                        <div class="font-semibold leading-none tracking-tight flex items-center gap-2 mb-4" style="font-weight: 600; display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px; color: #57a596;">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Healthcare Provider
                        </div>
                        <div class="flex items-center gap-4" style="display: flex; align-items: center; gap: 16px;">
                            <span class="relative flex shrink-0 overflow-hidden rounded-full" style="width: 64px; height: 64px; border-radius: 9999px; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 600; color: #57a596;">
                                oD
                            </span>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold" style="font-size: 16px; font-weight: 600; color: #111827;">Dr. {{ $appointment->doctor->name ?? 'ourPhoneMd Doctor' }}</h3>
                                <p class="text-gray-600" style="color: #6b7280; font-size: 14px;">Healthcare Provider</p>
                                <div class="flex items-center gap-2 mt-2" style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #9ca3af;">
                                        <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600" style="font-size: 14px; color: #6b7280;">{{ $appointment->doctor->email ?? 'doctor@gmail.com' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="space-y-6" style="display: flex; flex-direction: column; gap: 24px;">
                <!-- Actions Card -->
                <div class="rounded-xl border bg-white shadow" style="border-radius: 12px; border: 1px solid #e5e7eb; background-color: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
                    <div class="p-6" style="padding: 24px;">
                        <div class="font-semibold leading-none tracking-tight mb-4" style="font-weight: 600; margin-bottom: 16px;">Actions</div>
                        @if($appointment->status === 'in_progress' || $appointment->status === 'confirmed')
                            <button type="button" class="btn btn-primary w-full" id="joinVideoCallBtn" style="background-color: #06b38a; color: white; width: 100%; padding: 10px; border-radius: 8px; font-weight: 600; border: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M23 7l-7 5 7 5V7z"></path>
                                    <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                                </svg>
                                Join Video Call
                            </button>
                        @elseif($appointment->status === 'pending')
                            <p class="text-gray-500 text-sm">Appointment is pending confirmation.</p>
                        @else
                             <p class="text-gray-500 text-sm">Action not available.</p>
                        @endif
                        
                        @if($appointment->status === 'pending' || $appointment->status === 'confirmed')
                             <form action="{{ route('patient.cancel.appointment', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?');" style="margin-top: 12px;">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-full" style="width: 100%; padding: 10px; border-radius: 8px; font-weight: 600; border: 1px solid #ef4444; color: #ef4444; background: transparent;">Cancel Appointment</button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Payment Details Card -->
                <div class="rounded-xl border bg-white shadow" style="border-radius: 12px; border: 1px solid #e5e7eb; background-color: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
                    <div class="p-6" style="padding: 24px;">
                        <div class="font-semibold leading-none tracking-tight flex items-center gap-2 mb-4" style="font-weight: 600; display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px; color: #57a596;">
                                <rect width="20" height="14" x="2" y="5" rx="2"></rect>
                                <line x1="2" x2="22" y1="10" y2="10"></line>
                            </svg>
                            Payment Details
                        </div>
                        <div class="space-y-4" style="display: flex; flex-direction: column; gap: 16px;">
                            <div class="flex items-center justify-between" style="display: flex; align-items: center; justify-content: space-between;">
                                <span class="text-sm text-gray-500" style="font-size: 13px; color: #6b7280;">Status</span>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold" style="background-color: #22c55e; color: white; border-radius: 9999px; padding: 4px 10px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    {{ $appointment->payment && $appointment->payment->status == 'succeeded' ? 'SUCCEEDED' : 'PENDING' }}
                                </span>
                            </div>
                            <div style="height: 1px; background-color: #e5e7eb;"></div>
                            <div class="flex items-center justify-between" style="display: flex; align-items: center; justify-content: space-between;">
                                <span class="text-sm text-gray-500" style="font-size: 13px; color: #6b7280;">Payment Method</span>
                                <span class="font-medium capitalize" style="font-weight: 500; color: #111827; text-transform: capitalize;">{{ $appointment->payment->method ?? 'Insurance' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes & Attachments Card -->
                <div class="rounded-xl border bg-white shadow" style="border-radius: 12px; border: 1px solid #e5e7eb; background-color: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
                    <div class="p-6" style="padding: 24px;">
                        <div class="font-semibold leading-none tracking-tight mb-4" style="font-weight: 600; margin-bottom: 16px;">Doctor Notes & Attachments</div>
                        
                        @if($appointment->patientNotes && $appointment->patientNotes->where('is_visible_to_patient', true)->count() > 0)
                            <div class="space-y-3" style="display: flex; flex-direction: column; gap: 12px;">
                                @foreach($appointment->patientNotes as $note)
                                    @if($note->is_visible_to_patient)
                                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200" style="padding: 12px; background-color: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                                        <div class="flex justify-between items-start mb-2" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                            <span class="text-xs font-semibold text-gray-500 uppercase" style="font-size: 11px; font-weight: 600; color: #6b7280; text-transform: uppercase;">{{ $note->type }} Note</span>
                                            <span class="text-xs text-gray-400" style="font-size: 11px; color: #9ca3af;">{{ $note->sent_at ? $note->sent_at->format('M d, h:i A') : $note->created_at->format('M d, h:i A') }}</span>
                                        </div>
                                        
                                        @if($note->content)
                                            <p class="text-sm text-gray-700 mb-2" style="font-size: 14px; color: #374151; margin-bottom: 8px;">{{ $note->content }}</p>
                                        @endif

                                        @if($note->attachment_path)
                                            <a href="{{ asset('storage/'.$note->attachment_path) }}" target="_blank" class="inline-flex items-center gap-2 text-sm text-customTeal hover:underline" style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; color: #57a596; text-decoration: none;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                                </svg>
                                                View Attachment
                                            </a>
                                        @endif
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 text-gray-500 text-sm" style="text-align: center; padding: 16px 0; color: #6b7280; font-size: 14px;">
                                No notes shared yet.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Info Card -->
                <div class="rounded-xl border bg-white shadow" style="border-radius: 12px; border: 1px solid #e5e7eb; background-color: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
                    <div class="p-6" style="padding: 24px;">
                        <div class="font-semibold tracking-tight text-lg mb-4" style="font-weight: 600; font-size: 16px; margin-bottom: 16px;">Quick Info</div>
                        <div class="space-y-3" style="display: flex; flex-direction: column; gap: 12px;">
                            <div class="flex items-center justify-between" style="display: flex; align-items: center; justify-content: space-between;">
                                <span class="text-sm text-gray-500" style="font-size: 13px; color: #6b7280;">Created</span>
                                <span class="text-sm" style="font-size: 13px; color: #111827;">{{ \Carbon\Carbon::parse($appointment->created_at)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between" style="display: flex; align-items: center; justify-content: space-between;">
                                <span class="text-sm text-gray-500" style="font-size: 13px; color: #6b7280;">Last Updated</span>
                                <span class="text-sm" style="font-size: 13px; color: #111827;">{{ \Carbon\Carbon::parse($appointment->updated_at)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between" style="display: flex; align-items: center; justify-content: space-between;">
                                <span class="text-sm text-gray-500" style="font-size: 13px; color: #6b7280;">Appointment ID</span>
                                <span class="text-sm font-mono text-gray-600" style="font-size: 11px; font-family: monospace; color: #6b7280;">{{ substr($appointment->token, 0, 10) }}...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="alert alert-danger" style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 16px; border-radius: 8px;">Appointment not found.</div>
        @endif
    </div>
</div>
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const joinBtn = document.getElementById('joinVideoCallBtn');
        if (joinBtn) {
            joinBtn.addEventListener('click', function() {
                // Check for active call via the polling endpoint we created
                joinBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Connecting...';
                joinBtn.disabled = true;

                fetch('{{ route("patient.video.check") }}')
                .then(res => res.json())
                .then(data => {
                    if(data.incoming) {
                         // Call found, join it
                         fetch('/patient/video/' + data.call_id + '/join', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(res => res.json())
                            .then(joinData => {
                                if(joinData.success) {
                                    window.open(joinData.room_url || 'https://meet.jit.si/' + joinData.room_name, '_blank');
                                    joinBtn.innerHTML = 'Join Video Call';
                                    joinBtn.disabled = false;
                                } else {
                                    alert('Could not join call. It may have ended.');
                                    joinBtn.innerHTML = 'Join Video Call';
                                    joinBtn.disabled = false;
                                }
                            });
                    } else {
                        alert('No active video call found for this appointment. Please wait for the doctor to start the call.');
                        joinBtn.innerHTML = 'Join Video Call';
                        joinBtn.disabled = false;
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Error checking for call.');
                    joinBtn.innerHTML = 'Join Video Call';
                    joinBtn.disabled = false;
                });
            });
        }
    });
</script>
@endsection
@endsection
