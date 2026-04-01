<div class="row">
    <div class="col-md-6 mb-3">
        <div class="info-item">
            <label class="info-label">Name:</label>
            <span class="info-value">{{ $patient->first_name }} {{ $patient->last_name }}</span>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="info-item">
            <label class="info-label">Email:</label>
            <span class="info-value">{{ $patient->email }}</span>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="info-item">
            <label class="info-label">Phone:</label>
            <span class="info-value">{{ $patient->contact_number }}</span>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="info-item">
            <label class="info-label">Date of Birth:</label>
            <span class="info-value">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }} ({{ $patient->age }} years old)</span>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="info-item">
            <label class="info-label">CNIC:</label>
            <span class="info-value">{{ $patient->cnic }}</span>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="info-item">
            <label class="info-label">Blood Group:</label>
            <span class="info-value">{{ $patient->blood_group }}</span>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="info-item">
            <label class="info-label">Gender:</label>
            <span class="info-value">{{ ucfirst($patient->gender ?: 'Not specified') }}</span>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="info-item">
            <label class="info-label">Marital Status:</label>
            <span class="info-value">{{ ucfirst($patient->marital_status ?: 'Not specified') }}</span>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="info-item">
            <label class="info-label">Emergency Contact:</label>
            <span class="info-value">{{ $patient->emergency_contact ?: 'Not specified' }}</span>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="info-item">
            <label class="info-label">Address:</label>
            <span class="info-value">{{ $patient->address }}, {{ $patient->city }}, {{ $patient->state }} {{ $patient->zip_code }}</span>
        </div>
    </div>
    @if($patient->medical_history)
    <div class="col-md-12 mb-3">
        <div class="info-item">
            <label class="info-label">Medical History:</label>
            <span class="info-value">{{ $patient->medical_history }}</span>
        </div>
    </div>
    @endif
</div>

<style>
.info-item {
    display: flex;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-label {
    font-weight: 600;
    color: #333;
    min-width: 140px;
    margin-right: 15px;
    font-size: 14px;
}

.info-value {
    color: #666;
    font-size: 14px;
    flex: 1;
}

@media (max-width: 768px) {
    .info-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .info-label {
        min-width: auto;
        margin-bottom: 4px;
        margin-right: 0;
    }

    .info-value {
        width: 100%;
    }
}
</style>
