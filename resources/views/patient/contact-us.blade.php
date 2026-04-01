@extends('layouts.patient')

@section('title', 'Contact Us - OurPhoneMD')

@section('content')
<div class="container-fluid py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-md-8 mx-auto text-center">
                <h1 class="h2 fw-bold mb-3" style="color: #2c3e50;">Contact Us</h1>
                <p class="text-muted" style="font-size: 14px;">We're here to help! Get in touch with us for any questions about appointments, billing, insurance, or general inquiries. Our team is ready to assist you.</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="row g-4 mb-5">
            <!-- Left Column: Get in Touch & Office Hours -->
            <div class="col-md-6">
                <!-- Get in Touch Card -->
                <div class="card border-0 shadow-sm mb-4" style="overflow: hidden;">
<!-- Card Header with Light Green Background -->
<div style="background-color: #e8f5f1; padding: 20px;">
    <div class="d-flex align-items-center">
        <i class="fas fa-comments" style="color: #26b99a; font-size: 20px;"></i>
        <h5 class="ms-3 mb-0 fw-bold" style="color: #26b99a;">Get in Touch</h5>
    </div>
    <p class="text-muted small mt-2 mb-0" style="font-size: 12px;">Choose the best way to reach us based on your needs</p>
</div>
                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Billing Questions Mini-card -->
                        <div class="mb-3 p-3" style="border-left: 3px solid #26b99a; background-color: #fafafa;">
                            <div class="d-flex mb-2">
                                <i class="fas fa-envelope" style="color: #26b99a; font-size: 16px; margin-right: 10px;"></i>
                                <h6 class="mb-0 fw-bold" style="color: #2c3e50;">Billing Questions</h6>
                            </div>
                            <p class="text-muted small mb-1" style="margin-left: 26px;">For payment, insurance, and billing inquiries</p>
                            <a href="mailto:Inquiry.OPMD@yahoo.com" style="color: #26b99a; text-decoration: none; font-size: 13px; margin-left: 26px;">Inquiry.OPMD@yahoo.com</a>
                        </div>

                        <!-- General Inquiries Mini-card -->
                        <div class="mb-3 p-3" style="border-left: 3px solid #26b99a; background-color: #fafafa;">
                            <div class="d-flex mb-2">
                                <i class="fas fa-envelope" style="color: #26b99a; font-size: 16px; margin-right: 10px;"></i>
                                <h6 class="mb-0 fw-bold" style="color: #2c3e50;">General Inquiries</h6>
                            </div>
                            <p class="text-muted small mb-1" style="margin-left: 26px;">For general questions and support</p>
                            <a href="mailto:Inquiry.OPMD@yahoo.com" style="color: #26b99a; text-decoration: none; font-size: 13px; margin-left: 26px;">Inquiry.OPMD@yahoo.com</a>
                        </div>

                        <!-- Phone Support Mini-card -->
                        <div class="p-3" style="border-left: 3px solid #26b99a; background-color: #fafafa;">
                            <div class="d-flex mb-2">
                                <i class="fas fa-phone" style="color: #26b99a; font-size: 16px; margin-right: 10px;"></i>
                                <h6 class="mb-0 fw-bold" style="color: #2c3e50;">Phone Support</h6>
                            </div>
                            <p class="text-muted small mb-1" style="margin-left: 26px;">Call us directly for immediate assistance</p>
                            <a href="tel:(270)769-0110" style="color: #26b99a; text-decoration: none; font-size: 13px; font-weight: bold; margin-left: 26px;">(270) 769-0110</a>
                        </div>
                    </div>
                </div>

                <!-- Office Hours Card -->
                <div class="card border-0 shadow-sm" style="overflow: hidden;">
                    <!-- Card Header with Light Green Background -->
                    <div style="background-color: #e8f5f1; padding: 20px;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock" style="color: #26b99a; font-size: 20px;"></i>
                            <h5 class="ms-3 mb-0 fw-bold" style="color: #26b99a;">Office Hours</h5>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <div class="office-hours">
                            <div class="d-flex justify-content-between mb-3 p-3" style="background-color: #fafafa;">
                                <span class="fw-bold" style="color: #2c3e50;">Monday - Friday</span>
                                <span class="text-muted" style="font-size: 14px;">8:00 AM - 8:00 PM</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 p-3" style="background-color: #fafafa;">
                                <span class="fw-bold" style="color: #2c3e50;">Saturday</span>
                                <span class="text-muted" style="font-size: 14px;">9:00 AM - 5:00 PM</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 p-3" style="background-color: #fafafa;">
                                <span class="fw-bold" style="color: #2c3e50;">Sunday</span>
                                <span class="text-muted" style="font-size: 14px;">10:00 AM - 4:00 PM</span>
                            </div>
                            <div class="alert alert-info py-2 px-3 mb-0" style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; font-size: 13px;">
                                <i class="fas fa-info-circle me-2"></i>Emergency services available 24/7
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Location & Quick Actions -->
            <div class="col-md-6">
                <!-- Location Card -->
                <div class="card border-0 shadow-sm mb-4" style="overflow: hidden;">
                    <!-- Card Header with Light Green Background -->
                    <div style="background-color: #e8f5f1; padding: 20px;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt" style="color: #26b99a; font-size: 20px;"></i>
                            <h5 class="ms-3 mb-0 fw-bold" style="color: #26b99a;">Our Location</h5>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #2c3e50;">OurPhoneMD Medical Center</h6>
                        <p class="mb-3" style="color: #555; font-size: 14px;">
                            123 Healthcare Drive<br>
                            Bowling Green, KY 42101
                        </p>
                        <!-- Updated Get Directions Button -->
                        <div class="text-center mt-4">
                            <a href="#" class="btn w-100 d-flex align-items-center justify-content-center" style="background-color: #26b99a; color: white; border: none; padding: 10px 16px; font-weight: 500;">
                                <i class="fas fa-map-pin me-2"></i>Get Directions
                                <i class="fas fa-external-link-alt ms-2" style="font-size: 12px;"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="card border-0 shadow-sm" style="overflow: hidden;">
<!-- Card Header with Light Green Background -->
<div style="background-color: #e8f5f1; padding: 20px;">
    <div class="d-flex align-items-center">
        <i class="fas fa-bolt" style="color: #26b99a; font-size: 20px;"></i>
        <h5 class="ms-3 mb-0 fw-bold" style="color: #26b99a;">Quick Actions</h5>
    </div>
    <p class="text-muted small mt-2 mb-0" style="font-size: 12px;">Common tasks you can complete online</p>
</div>
                    <!-- Card Body -->
                    <div class="card-body p-4">
<div class="list-group list-group-flush">
    <a href="http://127.0.0.1:8000/patient/appointments/new/step1" class="list-group-item list-group-item-action border-0 px-0 py-2" style="background-color: transparent; color: #555; font-size: 14px;">
        <i class="fas fa-calendar-check me-2" style="color: #26b99a;"></i>Book an Appointment
    </a>
    <a href="http://127.0.0.1:8000/patient/appointment-dashboard" class="list-group-item list-group-item-action border-0 px-0 py-2" style="background-color: transparent; color: #555; font-size: 14px;">
        <i class="fas fa-list me-2" style="color: #26b99a;"></i>View My Appointments
    </a>
    <a href="http://127.0.0.1:8000/patient/insurance" class="list-group-item list-group-item-action border-0 px-0 py-2" style="background-color: transparent; color: #555; font-size: 14px;">
        <i class="fas fa-shield-alt me-2" style="color: #26b99a;"></i>Manage Insurance
    </a>
    <a href="http://127.0.0.1:8000/patient/profile" class="list-group-item list-group-item-action border-0 px-0 py-2" style="background-color: transparent; color: #555; font-size: 14px;">
        <i class="fas fa-user me-2" style="color: #26b99a;"></i>Update Profile
    </a>
</div>
                    </div>
                </div>

                <!-- Emergency Contact Card -->
                <div class="card border-0 shadow-sm mt-4" style="overflow: hidden;">
                    <!-- Card Header with Light Red Background -->
                    <div style="background-color: #ffe8e8; padding: 20px; border-left: 4px solid #dc3545;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle" style="color: #dc3545; font-size: 20px;"></i>
                            <h5 class="ms-3 mb-0 fw-bold" style="color: #dc3545;">Emergency Contact</h5>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body p-4 text-center" style="background-color: #ffe8e8;">
                        <p class="text-muted small mb-3">For medical emergencies, please call</p>
                        <!-- 911 with light red background -->
                        <div class="mb-3 p-4 rounded" style="background-color: #ffe8e8; display: inline-block;">
                            <h2 class="fw-bold mb-0" style="color: #dc3545; letter-spacing: 3px; font-size: 48px;">911</h2>
                        </div>
                        <p class="text-muted small">Or visit your nearest emergency room</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Response Times Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="background-color: #f0f5ff; overflow: hidden;">
                    <div class="card-body p-5">
                        <h5 class="mb-4 fw-bold" style="color: #0066cc;">Response Times</h5>
                        <div class="row">
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                <div class="mb-2">
                                    <i class="fas fa-phone" style="color: #26b99a; font-size: 24px;"></i>
                                </div>
                                <h6 class="fw-bold mb-1" style="color: #2c3e50; font-size: 13px;">Phone Calls</h6>
                                <p class="text-muted small" style="font-size: 12px;">Immediate response during business hours</p>
                            </div>
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                <div class="mb-2">
                                    <i class="fas fa-envelope" style="color: #26b99a; font-size: 24px;"></i>
                                </div>
                                <h6 class="fw-bold mb-1" style="color: #2c3e50; font-size: 13px;">Email Inquiries</h6>
                                <p class="text-muted small" style="font-size: 12px;">Within 24 hours</p>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="mb-2">
                                    <i class="fas fa-flag" style="color: #26b99a; font-size: 24px;"></i>
                                </div>
                                <h6 class="fw-bold mb-1" style="color: #2c3e50; font-size: 13px;">Urgent Matters</h6>
                                <p class="text-muted small" style="font-size: 12px;">Same day response</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
