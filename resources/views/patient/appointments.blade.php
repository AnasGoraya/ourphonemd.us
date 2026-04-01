@extends('layouts.patient')

@section('title', 'My Appointments - Laravel Clinic')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">My Appointments</h2>

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

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Your Appointments</h5>
                </div>
                <div class="card-body">
                    @if($appointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Doctor</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                            <td>{{ $appointment->appointment_time }}</td>
                                            <td>Dr. {{ $appointment->doctor->name ?? 'N/A' }}</td>
                                            <td>{{ $appointment->reason ?? 'N/A' }}</td>
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">You have no appointments scheduled.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Book New Appointment</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('patient.book.appointment') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="doctor_id" class="form-label">Select Doctor</label>
                            <select class="form-control" id="doctor_id" name="doctor_id" required>
                                <option value="">Choose a doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">Dr. {{ $doctor->name }} ({{ $doctor->role->name ?? 'Doctor' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="appointment_date" class="form-label">Appointment Date</label>
                            <input type="date" class="form-control" id="appointment_date" name="appointment_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="appointment_time" class="form-label">Appointment Time</label>
                            <input type="time" class="form-control" id="appointment_time" name="appointment_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="symptoms" class="form-label">Reason / Symptoms</label>
                            <textarea class="form-control" id="symptoms" name="symptoms" rows="3" placeholder="Brief description of your medical concern"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-control" id="priority" name="priority" required>
                                <option value="normal">Normal</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Book Appointment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
