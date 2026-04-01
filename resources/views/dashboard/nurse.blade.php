@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-nurse me-2"></i>Nurse Dashboard
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Welcome, {{ Auth::user()->name }}</h5>
                            <p class="text-muted">Manage patient care and assist with medical procedures</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="text-muted mb-0">Role: Nurse</p>
                            <p class="text-muted mb-0">Email: {{ Auth::user()->email }}</p>

                        </div>
                    </div>

                    <div class="text-center py-5">
                        <i class="fas fa-tools fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Dashboard Under Development</h5>
                        <p class="text-muted">Nurse dashboard features will be available soon.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
