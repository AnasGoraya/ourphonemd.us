@extends('layouts.doctor')

@section('title', 'Contact Us - OurPhoneMD')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="mb-4">
            <h1 class="h3 font-weight-bold text-gray-900" style="color: #1a2e35;">Contact Support</h1>
            <p class="text-muted">Need help? Get in touch with our administration team.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert" style="background-color: #ecfdf5; border-left: 5px solid #10b981; border-radius: 12px; color: #064e3b;">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-body p-4">
                        <h4 class="mb-4" style="font-weight: 700; color: #3EA293;">Send us a Message</h4>
                        <form action="{{ route('doctor.contact.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Your Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name) }}" style="border-radius: 10px; padding: 12px;">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Email Address</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" style="border-radius: 10px; padding: 12px;">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Subject</label>
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" placeholder="What can we help you with?" style="border-radius: 10px; padding: 12px;">
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label font-weight-bold">Message</label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="6" placeholder="Type your message here..." style="border-radius: 10px; padding: 12px;">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg px-5" style="background-color: #3EA293; border: none; border-radius: 10px; font-weight: 700;">
                                <i class="fas fa-paper-plane mr-2"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #3EA293 0%, #51A897 100%); color: white;">
                    <div class="card-body p-4">
                        <h4 class="mb-4" style="font-weight: 700;">Clinic Information</h4>
                        
                        <div class="d-flex mb-4">
                            <div class="mr-3 mt-1">
                                <i class="fas fa-hospital fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Clinic Name</h6>
                                <p class="mb-0 opacity-75">OurPhoneMD Main Clinic</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="mr-3 mt-1">
                                <i class="fas fa-map-marker-alt fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Address</h6>
                                <p class="mb-0 opacity-75">123 Medical Plaza, Suite 400<br>Healthcare City, HC 54321</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="mr-3 mt-1">
                                <i class="fas fa-phone-alt fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Phone Number</h6>
                                <p class="mb-0 opacity-75">+1 (555) 123-4567</p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="mr-3 mt-1">
                                <i class="fas fa-envelope fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Support Email</h6>
                                <p class="mb-0 opacity-75">support@ourphonemd.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="mb-3" style="font-weight: 700; color: #1a2e35;">Working Hours</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Monday - Friday</span>
                                <span class="font-weight-bold">08:00 AM - 08:00 PM</span>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Saturday</span>
                                <span class="font-weight-bold">09:00 AM - 05:00 PM</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="text-muted">Sunday</span>
                                <span class="font-weight-bold text-danger">Closed</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
