@extends('layouts.patient')

@section('title', 'Walk-in Appointments - OurPhoneMD')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Walk-in Appointments
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Coming Soon:</strong> Walk-in appointment scheduling is currently under development.
                    </div>

                    <div class="text-center py-5">
                        <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Walk-in Services</h4>
                        <p class="text-muted">Emergency and same-day appointment booking will be available here soon.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
