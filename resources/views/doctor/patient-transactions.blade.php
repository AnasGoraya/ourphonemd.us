@extends('layouts.doctor')

@section('title', 'Patient Transactions History')
@section('page_title', 'Patient Transactions')

@section('content')
<div style="padding:24px;">
    <div style="max-width:1100px; margin:0 auto;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <div style="display:flex; gap:12px; align-items:center;">
                <a href="{{ url('doctor/patients/' . $patient->id) }}" style="background:#f3f4f6; color:#0f172a; padding:8px 10px; border-radius:6px; text-decoration:none;">&larr; Back to Profile</a>
                <h2 style="margin:0; font-size:20px; color:#0f172a;">Transaction History: {{ $patient->first_name }} {{ $patient->last_name }}</h2>
            </div>
        </div>

        <div class="card" style="background:#fff; border-radius:12px; border:1px solid #eef3f2; padding:20px;">
            @if($transactions->count() > 0)
                <table class="table" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="border-bottom:2px solid #f0f0f0;">
                            <th style="text-align:left; padding:12px; color:#666;">Date</th>
                            <th style="text-align:left; padding:12px; color:#666;">Validation ID</th>
                            <th style="text-align:left; padding:12px; color:#666;">Description</th>
                            <th style="text-align:left; padding:12px; color:#666;">Amount</th>
                            <th style="text-align:left; padding:12px; color:#666;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $txn)
                            <tr style="border-bottom:1px solid #f9f9f9;">
                                <td style="padding:16px 12px;">{{ $txn->created_at->format('M d, Y h:i A') }}</td>
                                <td style="padding:16px 12px; font-family:monospace; color:#333;">{{ substr($txn->stripe_charge_id ?? $txn->stripe_id ?? '---', 0, 12) }}...</td>
                                <td style="padding:16px 12px;">{{ $txn->description ?? 'Consultation Fee' }}</td>
                                <td style="padding:16px 12px; font-weight:700;">${{ number_format($txn->amount, 2) }}</td>
                                <td style="padding:16px 12px;">
                                    <span style="padding:4px 10px; border-radius:12px; font-size:12px; font-weight:700;
                                        background: {{ $txn->status == 'succeeded' ? '#dcfce7' : '#fee2e2' }};
                                        color: {{ $txn->status == 'succeeded' ? '#166534' : '#991b1b' }};">
                                        {{ ucfirst($txn->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding:40px; text-align:center; color:#999;">
                    <i class="fas fa-receipt" style="font-size:32px; margin-bottom:12px; opacity:0.5;"></i>
                    <p>No transaction history found for this patient.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
