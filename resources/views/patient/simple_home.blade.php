@extends('layouts.patient')

@section('title', 'Home - Laravel Clinic')

@section('content')
<div class="text-center">
    <h1>Welcome to Laravel Clinic</h1>
    <p>This is a simple test homepage</p>
    <a href="/patient/signin" class="btn btn-success">Sign In</a>
    <a href="/patient/signup" class="btn btn-outline-success">Sign Up</a>
</div>
@endsection
