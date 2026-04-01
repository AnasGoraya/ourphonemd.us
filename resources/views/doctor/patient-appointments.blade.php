@extends('layouts.doctor')

@section('title', 'Patient Appointments History')
@section('page_title', 'Patient Appointments')

@section('content')
<div style="padding:24px;">
    <div style="max-width:1100px; margin:0 auto;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <div style="display:flex; gap:12px; align-items:center;">
                <a href="{{ url('doctor/patients/' . $patient->id) }}" style="background:#f3f4f6; color:#0f172a; padding:8px 10px; border-radius:6px; text-decoration:none;">&larr; Back to Profile</a>
                <h2 style="margin:0; font-size:20px; color:#0f172a;">Past Appointments: {{ $patient->first_name }} {{ $patient->last_name }}</h2>
            </div>
        </div>

        <div class="card" style="background:#fff; border-radius:12px; border:1px solid #eef3f2; padding:20px;">
            @if($appointments->count() > 0)
                <table class="table" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="border-bottom:2px solid #f0f0f0;">
                            <th style="text-align:left; padding:12px; color:#666;">Date</th>
                            <th style="text-align:left; padding:12px; color:#666;">Time</th>
                            <th style="text-align:left; padding:12px; color:#666;">Reason</th>
                            <th style="text-align:left; padding:12px; color:#666;">Status</th>
                            <th style="text-align:right; padding:12px; color:#666;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $apt)
                            <tr style="border-bottom:1px solid #f9f9f9;">
                                <td style="padding:16px 12px;">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('M d, Y') }}</td>
                                <td style="padding:16px 12px;">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i A') }}</td>
                                <td style="padding:16px 12px;">{{ $apt->reason ?? '—' }}</td>
                                <td style="padding:16px 12px;">
                                    <span style="padding:4px 10px; border-radius:12px; font-size:12px; font-weight:700;
                                        background: {{ $apt->status == 'completed' ? '#dcfce7' : ($apt->status == 'cancelled' ? '#fee2e2' : '#e0f2fe') }};
                                        color: {{ $apt->status == 'completed' ? '#166534' : ($apt->status == 'cancelled' ? '#991b1b' : '#0369a1') }};">
                                        {{ ucfirst($apt->status) }}
                                    </span>
                                </td>
                                <td style="padding:16px 12px; text-align:right;">
                                    <a href="{{ route('doctor.appointment.detail', $apt->id) }}" style="color:#1aa179; font-weight:600; text-decoration:none;">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding:40px; text-align:center; color:#999;">
                    <i class="fas fa-calendar-times" style="font-size:32px; margin-bottom:12px; opacity:0.5;"></i>
                    <p>No past appointments found for this patient.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
