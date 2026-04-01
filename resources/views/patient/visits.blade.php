@extends('layouts.patient')

@section('title', 'My Visits - OurPhoneMD')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-file-medical me-2"></i>My Completed Visits
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Coming Soon:</strong> This feature is currently under development. You will be able to view your completed visit history here.
                    </div>

                    <div class="text-center py-5">
                        <i class="fas fa-file-medical fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Visit History</h4>
                        <p class="text-muted">Your completed visits will appear here once the feature is fully implemented.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
