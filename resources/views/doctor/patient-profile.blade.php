@extends('layouts.doctor')

@section('title', 'Patient Profile')
@section('page_title', 'Patient Profile')

@section('content')
<div style="padding:24px;">
    <div style="max-width:1100px; margin:0 auto;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
            <div style="display:flex; gap:12px; align-items:center;">
                <a href="{{ url('doctor/patients') }}" style="background:#f3f4f6; color:#0f172a; padding:8px 10px; border-radius:6px; text-decoration:none;">&larr; Back</a>
                <h2 style="margin:0; font-size:20px; color:#0f172a;">Patient Profile</h2>
            </div>
            <div>
                <a href="{{ url('doctor/patients/'.$patient->id.'/edit') }}" style="background:#1aa179; color:#fff; padding:8px 12px; border-radius:6px; text-decoration:none; font-weight:700;">Edit Profile</a>
            </div>
        </div>

        <!-- Header card -->
        <div style="background:linear-gradient(90deg,#0ea785,#0b8f73); color:#fff; padding:22px; border-radius:8px; display:flex; gap:18px; align-items:center;">
            <div style="width:96px; height:96px; border-radius:50%; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; font-size:32px; font-weight:700;">{{ strtoupper(substr($patient->first_name,0,1) . (isset($patient->last_name)?substr($patient->last_name,0,1):'')) }}</div>
            <div style="flex:1;">
                <div style="font-size:22px; font-weight:800;">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                <div style="margin-top:10px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                    <div style="background:rgba(255,255,255,0.12); padding:6px 10px; border-radius:6px; font-weight:700;">Age: {{ $patient->calculated_age ?? $patient->age ?? '—' }}</div>
                    <div style="background:rgba(255,255,255,0.12); padding:6px 10px; border-radius:6px; font-weight:700;">{{ $patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : '—' }}</div>
                </div>
            </div>
            <div style="min-width:160px; text-align:right;">
                <div style="font-weight:700;">Registered on</div>
                <div style="color:rgba(255,255,255,0.9); margin-top:6px;">{{ $patient->created_at ? $patient->created_at->format('M d, Y') : '—' }}</div>
            </div>
        </div>

        <!-- Info cards -->
        <div style="display:flex; gap:12px; margin-top:16px;">
            <div style="flex:1; display:flex; gap:12px;">
                <div style="flex:1; background:#f1faf8; padding:16px; border-radius:8px;">
                    <div style="font-weight:700; color:#0f172a;">Email</div>
                    <div style="color:#6b7280; margin-top:8px;">{{ $patient->email ?? '—' }}</div>
                </div>
                <div style="flex:1; background:#f0fef6; padding:16px; border-radius:8px;">
                    <div style="font-weight:700; color:#0f172a;">Phone</div>
                    <div style="color:#6b7280; margin-top:8px;">{{ $patient->contact_number ?? '—' }}</div>
                </div>
                <div style="flex:1; background:#fff5f5; padding:16px; border-radius:8px;">
                    <div style="font-weight:700; color:#0f172a;">Address</div>
                    <div style="color:#6b7280; margin-top:8px;">{{ $patient->address ?? '—' }}</div>
                </div>
            </div>
        </div>

        <!-- Action tiles -->
        <div style="display:flex; gap:12px; margin-top:18px;">
            <div style="flex:1; display:flex; gap:12px;">
                <a href="{{ url('doctor/patients/'.$patient->id.'/appointments') }}" style="flex:1; background:#fff; border-radius:8px; padding:18px; box-shadow:0 1px 2px rgba(0,0,0,0.04); text-align:center; text-decoration:none; color:#0f172a;">
                    <div style="font-weight:700;">Past Appointments</div>
                </a>
                <a href="{{ url('doctor/patients/'.$patient->id.'/transactions') }}" style="flex:1; background:#fff; border-radius:8px; padding:18px; box-shadow:0 1px 2px rgba(0,0,0,0.04); text-align:center; text-decoration:none; color:#0f172a;">
                    <div style="font-weight:700;">Transaction History</div>
                </a>
                <a href="#" style="flex:1; background:#fff; border-radius:8px; padding:18px; box-shadow:0 1px 2px rgba(0,0,0,0.04); text-align:center; text-decoration:none; color:#0f172a;">
                    <div style="font-weight:700;">Work/School Notes</div>
                </a>
                <a href="#" style="flex:1; background:#fff; border-radius:8px; padding:18px; box-shadow:0 1px 2px rgba(0,0,0,0.04); text-align:center; text-decoration:none; color:#0f172a;">
                    <div style="font-weight:700;">Other Payments</div>
                </a>
                <a href="#" style="flex:1; background:#fff; border-radius:8px; padding:18px; box-shadow:0 1px 2px rgba(0,0,0,0.04); text-align:center; text-decoration:none; color:#0f172a;">
                    <div style="font-weight:700;">Patient Notes</div>
                </a>
            </div>
        </div>

        <!-- Family Members -->
        <div style="margin-top:22px; background:#fff; padding:16px; border-radius:8px; box-shadow:0 1px 2px rgba(0,0,0,0.04);">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h3 style="margin:0;">Family Members</h3>
                <a href="#" style="background:#1aa179; color:#fff; padding:8px 12px; border-radius:6px; text-decoration:none;">+ Add Family Member</a>
            </div>
            <div style="margin-top:12px;">
                @if(method_exists($patient, 'familyMembers') && $patient->familyMembers->count())
                    @foreach($patient->familyMembers as $fm)
                        <div style="background:#f8fafb; padding:12px; border-radius:8px; margin-bottom:8px; display:flex; align-items:center; justify-content:space-between;">
                            <div style="display:flex; gap:12px; align-items:center;"><div style="width:36px; height:36px; border-radius:50%; background:#f3f4f6; display:flex; align-items:center; justify-content:center; color:#374151; font-weight:700;">{{ strtoupper(substr($fm->first_name,0,1)) }}</div><div><div style="font-weight:700">{{ $fm->first_name }} {{ $fm->last_name }}</div><div style="color:#6b7280; font-size:13px">{{ $fm->relationship ?? '' }}</div></div></div>
                            <div>
                                <a href="#" style="margin-right:8px; color:#1aa179;">View</a>
                                <a href="#" style="color:#ef4444;">Delete</a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="color:#6b7280;">No family members.</div>
                @endif
            </div>
        </div>

        <!-- Insurance Information -->
        <div style="margin-top:22px; background:#fff; padding:16px; border-radius:8px; box-shadow:0 1px 2px rgba(0,0,0,0.04); margin-bottom:40px;">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h3 style="margin:0;">Insurance Information</h3>
                <a href="#" style="background:#1aa179; color:#fff; padding:8px 12px; border-radius:6px; text-decoration:none;">+ Add Insurance</a>
            </div>
            <div style="margin-top:12px;">
                @if(method_exists($patient, 'insurances') && $patient->insurances->count())
                    @foreach($patient->insurances as $ins)
                        <div style="background:#f8fafb; border-radius:8px; padding:12px; margin-bottom:12px;">
                            <div style="font-weight:700;">{{ $ins->provider_name ?? 'Insurance' }} <span style="background:#10b981; color:#fff; padding:4px 8px; border-radius:12px; font-weight:700; font-size:12px; float:right;">Primary</span></div>
                            <div style="color:#6b7280; margin-top:8px;">Subscriber: {{ $ins->subscriber_name ?? '—' }}</div>
                        </div>
                    @endforeach
                @else
                    <div style="color:#6b7280;">No insurance information.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
