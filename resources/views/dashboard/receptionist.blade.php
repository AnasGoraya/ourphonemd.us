@extends('layouts.receptionist')

@section('title', 'Receptionist Dashboard - OurPhoneMD')

@section('page_title', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Welcome {{ Auth::user()->name }}!</h1>
        <p class="dashboard-subtitle">Manage patient appointments and coordinate with doctors</p>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <!-- Pending Appointments -->
            <div class="stat-card">
                <div class="stat-icon pending">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-number">{{ $pendingAppointments->count() }}</div>
                <div class="stat-label">Pending Appointments</div>
            </div>

            <!-- Sent Appointments -->
            <div class="stat-card">
                <div class="stat-icon sent">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </div>
                <div class="stat-number">{{ $sentAppointments->count() }}</div>
                <div class="stat-label">Sent to Doctors</div>
            </div>
        </div>
    </div>

    <!-- Appointments Tables -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Pending Appointments
                        <span class="badge bg-warning">{{ $pendingAppointments->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($pendingAppointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Doctor</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Priority</th>
                                        <th>Contact Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendingAppointments as $appointment)
                                        <tr>
                                            <td>
                                                @if ($appointment->patient)
                                                    <button class="btn btn-link p-0 text-decoration-none" type="button" data-bs-toggle="modal" data-bs-target="#patientModal{{ $appointment->id }}">
                                                        {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                                    </button>
                                                @else
                                                    <span class="text-muted">Patient not found</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($appointment->doctor)
                                                    Dr. {{ $appointment->doctor->name }}
                                                @else
                                                    <span class="text-muted">Doctor not assigned</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                            <td>{{ $appointment->appointment_time }}</td>
                                            <td>
                                                <span class="badge {{ $appointment->priority == 'urgent' ? 'bg-danger' : 'bg-info' }}">
                                                    {{ ucfirst($appointment->priority) }}
                                                </span>
                                            </td>
                                            <td>{{ $appointment->patient->contact_number ?: 'Not specified' }}</td>
                                            <td>
                                                <form action="{{ route('receptionist.send.to.doctor', $appointment->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Send to Doctor">
                                                        <i class="fas fa-paper-plane me-1"></i>Send to Doctor
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <h6 class="text-muted">No Pending Appointments</h6>
                            <p class="text-muted small">All appointments have been processed.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sent Appointments Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-paper-plane me-2"></i>Sent Appointments
                        <span class="badge bg-info">{{ $sentAppointments->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if ($sentAppointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Doctor</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Priority</th>
                                        <th>Contact Number</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sentAppointments as $appointment)
                                        <tr>
                                            <td>
                                                @if ($appointment->patient)
                                                    <button class="btn btn-link p-0 text-decoration-none" type="button" data-bs-toggle="modal" data-bs-target="#patientModalSent{{ $appointment->id }}">
                                                        {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                                    </button>
                                                @else
                                                    <span class="text-muted">Patient not found</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($appointment->doctor)
                                                    Dr. {{ $appointment->doctor->name }}
                                                @else
                                                    <span class="text-muted">Doctor not assigned</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                            <td>{{ $appointment->appointment_time }}</td>
                                            <td>
                                                <span class="badge {{ $appointment->priority == 'urgent' ? 'bg-danger' : 'bg-info' }}">
                                                    {{ ucfirst($appointment->priority) }}
                                                </span>
                                            </td>
                                            <td>{{ $appointment->patient->contact_number ?: 'Not specified' }}</td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Sent to Doctor
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <h6 class="text-muted">No Sent Appointments</h6>
                            <p class="text-muted small">Appointments sent to doctors will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Patient Detail Modals for Pending Appointments -->
@foreach ($pendingAppointments as $appointment)
    @if ($appointment->patient)
        <div class="modal fade" id="patientModal{{ $appointment->id }}" tabindex="-1" aria-labelledby="patientModalLabel{{ $appointment->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="patientModalLabel{{ $appointment->id }}">Patient Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('components.patient-card', ['patient' => $appointment->patient])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<!-- Patient Detail Modals for Sent Appointments -->
@foreach ($sentAppointments as $appointment)
    @if ($appointment->patient)
        <div class="modal fade" id="patientModalSent{{ $appointment->id }}" tabindex="-1" aria-labelledby="patientModalSentLabel{{ $appointment->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="patientModalSentLabel{{ $appointment->id }}">Patient Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('components.patient-card', ['patient' => $appointment->patient])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection

<style>
.dashboard-container {
    padding: 20px;
}
.dashboard-header {
    margin-bottom: 30px;
}
.dashboard-title {
    color: #2c3e50;
    margin-bottom: 10px;
}
.dashboard-subtitle {
    color: #666;
    margin-bottom: 20px;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.stat-card {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    text-decoration: none;
    color: inherit;
    transition: transform 0.3s;
}
.stat-card:hover {
    transform: translateY(-5px);
    color: inherit;
}
.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
}
.stat-icon.pending { background-color: #fff3e0; color: #f57c00; }
.stat-icon.sent { background-color: #e8f5e8; color: #388e3c; }
.stat-number {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 5px;
}
.stat-label {
    color: #666;
    margin-bottom: 10px;
}
</style>
