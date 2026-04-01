@extends('layouts.signup')

@section('title', 'Terms - OurPhoneMD')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h1>Terms & Conditions</h1>
        <div class="card">
            <div class="card-body">
                <p>Simple terms page for testing.</p>
                <form action="{{ route('signup.accept-terms') }}" method="POST">
                    @csrf
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="terms_accepted" id="terms_accepted" required>
                        <label class="form-check-label" for="terms_accepted">
                            I accept the terms
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Next</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
