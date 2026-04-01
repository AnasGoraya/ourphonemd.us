@extends('layouts.doctor')

@section('title', 'Follow-up Appointments - Doctor Dashboard')
@section('page_title', 'Follow-up Appointments')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-redo text-info me-2"></i>Follow-up Appointments
                    </h2>
                    <p class="text-muted mb-0">Appointments marked as follow-up priority</p>
                </div>
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    @if($appointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Patient</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Priority</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td>
                                                @if($appointment->patient)
                                                    <div>
                                                        <strong>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $appointment->patient->email }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                            <td>{{ $appointment->appointment_time }}</td>
                                            <td>
                                                <span class="badge {{ $appointment->priority == 'urgent' ? 'bg-danger' : ($appointment->priority == 'follow-up' ? 'bg-info' : 'bg-secondary') }}">
                                                    {{ ucfirst($appointment->priority) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ ucfirst($appointment->type ?? 'regular') }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $statusLabel = 'Unknown';
                                                    $statusClass = 'bg-secondary';
                                                    switch ($appointment->status) {
                                                        case 'in_progress':
                                                            $statusLabel = 'In Progress';
                                                            $statusClass = 'bg-warning';
                                                            break;
                                                        case 'scheduled':
                                                            $statusLabel = 'Scheduled';
                                                            $statusClass = 'bg-success';
                                                            break;
                                                        case 'confirmed':
                                                            $statusLabel = 'Confirmed';
                                                            $statusClass = 'bg-success';
                                                            break;
                                                        case 'pending':
                                                            $statusLabel = 'Pending';
                                                            $statusClass = 'bg-warning';
                                                            break;
                                                        case 'completed':
                                                            $statusLabel = 'Completed';
                                                            $statusClass = 'bg-secondary';
                                                            break;
                                                        case 'cancelled':
                                                            $statusLabel = 'Cancelled';
                                                            $statusClass = 'bg-danger';
                                                            break;
                                                    }
                                                @endphp
                                                <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('doctor.appointment.detail', $appointment->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-redo fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">No follow-up appointments</h4>
                            <p class="text-muted">Follow-up appointments will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
