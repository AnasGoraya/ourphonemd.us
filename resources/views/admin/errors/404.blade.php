@extends('layouts.admin')

@section('title', 'Page Not Found - 404')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <div class="error-icon mb-4">
                        <i class="fas fa-exclamation-triangle text-primary display-1"></i>
                    </div>
                    <h1 class="display-4 fw-bold text-primary mb-3">404</h1>
                    <h2 class="mb-3">Page Not Found</h2>
                    <p class="text-muted mb-4 lead">The page you are looking for doesn't exist or has been moved.</p>

                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-tachometer-alt me-2"></i>Back to Dashboard
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Go Back
                        </button>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top">
                        <small class="text-muted">
                            If you believe this is an error, please contact
                            <a href="mailto:support@yourcompany.com" class="text-decoration-none">support</a>.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-icon {
    animation: bounce 2s infinite;
}
@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
    40% {transform: translateY(-10px);}
    60% {transform: translateY(-5px);}
}
</style>
@endsection
