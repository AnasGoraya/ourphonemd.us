{{-- @extends('layouts.app')

@section('content') --}}
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white text-center">
                    <h4><i class="fas fa-envelope"></i> Email Verification Required</h4>
                </div>
                <div class="card-body text-center">
                    <p class="mb-4">Before proceeding, please verify your email address by clicking on the link we just emailed to you.</p>

                    <p class="text-muted mb-4">If you didn't receive the email, we will gladly send you another.</p>

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-envelope"></i> Resend Verification Email
                        </button>
                    </form>

                    <div class="mt-4">
                        <a href="{{ url('login') }}" class="text-decoration-none">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @endsection --}}
