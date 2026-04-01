@extends('layouts.admin')

@section('title', 'Server Error - 500')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <div class="error-icon mb-4">
                        <i class="fas fa-server text-danger display-1"></i>
                    </div>
                    <h1 class="display-4 fw-bold text-danger mb-3">500</h1>
                    <h2 class="mb-3">Server Error</h2>
                    <p class="text-muted mb-4 lead">Something went wrong on our end. Our team has been notified and is working to fix it.</p>

                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <button onclick="location.reload()" class="btn btn-outline-warning btn-lg">
                            <i class="fas fa-redo me-2"></i>Try Again
                        </button>
                        <a href="mailto:support@yourcompany.com" class="btn btn-outline-info btn-lg">
                            <i class="fas fa-envelope me-2"></i>Contact Support
                        </a>
                    </div>

                    @if(config('app.debug'))
                    <div class="mt-4 p-3 bg-light rounded text-start">
                        <h6 class="text-muted">Technical Details:</h6>
                        <small class="text-muted">
                            {{ $exception->getMessage() }}<br>
                            File: {{ $exception->getFile() }}:{{ $exception->getLine() }}
                        </small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-icon {
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0% {transform: scale(1);}
    50% {transform: scale(1.05);}
    100% {transform: scale(1);}
}
</style>
@endsection
