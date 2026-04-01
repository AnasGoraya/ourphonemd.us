@extends('layouts.admin')

@section('title', 'Access Denied - 403')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <div class="error-icon mb-4">
                        <i class="fas fa-ban text-warning display-1"></i>
                    </div>
                    <h1 class="display-4 fw-bold text-warning mb-3">403</h1>
                    <h2 class="mb-3">Access Denied</h2>
                    <p class="text-muted mb-4 lead">You don't have permission to access this page.</p>

                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-tachometer-alt me-2"></i>Back to Dashboard
                        </a>
                        <a href="{{ url('/admin/support') }}" class="btn btn-outline-info btn-lg">
                            <i class="fas fa-headset me-2"></i>Request Access
                        </a>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <small class="text-muted">
                            If you need access to this page, please contact your administrator.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-icon {
    animation: shake 2s infinite;
}
@keyframes shake {
    0%, 100% {transform: rotate(0deg);}
    25% {transform: rotate(-5deg);}
    75% {transform: rotate(5deg);}
}
</style>
@endsection
