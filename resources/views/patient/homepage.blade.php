@extends('layouts.homepage')

@section('title', 'Home - OurPhoneMD Telemedicine Portal')

@section('content')


    <div class="hero-section" style="background-color: #279C8E !important; color: white; padding: 80px 0;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" style="padding-left: 60px;">
                    <h1 class="display-4 fw-bold mb-4">
                        Welcome to OurPhone<span style="color: yellow;">MD</span> <br> Portal
                    </h1>
                    <p class="lead mb-4" style="font-size: 1.25rem;">
                        Connect with board-certified healthcare providers <br> from the comfort of your home.
                        Make appointments in just one minute.
                    </p>
                    <div class="hero-buttons">
                        <a href="{{ route('patient.appointment.dashboard') }}" class="btn btn-lg me-3 mb-3"
                            style="background-color: #FFC107; border-color: #FFC107; color: black;">
                            <i class="fas fa-calendar-check me-2"></i>Book Appointment
                        </a>
                        <a href="#services" class="btn btn-outline-light btn-lg mb-3"
                            style="border-color: white; color: rgba(255,255,255,0.9) !important;">
                            <i class="fas fa-list-alt me-2"></i>Our Services
                        </a>
                    </div>
                    <div class="hero-features mt-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle text-warning me-2"></i>
                            <span>24/7 Available Doctors</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle text-warning me-2"></i>
                            <span>Instant Video Consultations</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-warning me-2"></i>
                            <span>Secure & Private</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="hero-image-placeholder"
                        style="background: rgba(255,255,255,0.1); border-radius: 20px; padding: 40px;">
                        <i class="fas fa-laptop-medical" style="font-size: 200px; color: rgba(255,255,255,0.8);"></i>
                        <p class="mt-3">Telemedicine Platform</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section id="services" class="section bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Doctor Services</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="/images/a2.png" class="card-img-top" alt="General Medicine"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">General Medicine</h5>
                            <p class="card-text">Comprehensive primary healthcare services for all your medical needs.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="/images/a3.png" class="card-img-top" alt="Specialized Care"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">Specialized Care</h5>
                            <p class="card-text">Expert care in various medical specialties tailored to your needs.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="/images/a4.png" class="card-img-top" alt="Emergency Services"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">Emergency Services</h5>
                            <p class="card-text">24/7 emergency medical services for urgent healthcare needs.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="mission" class="section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>Our Mission</h2>
                    <p>To provide exceptional healthcare services with compassion, innovation, and excellence. We are
                        committed to improving the health and well-being of our community through patient-centered care and
                        cutting-edge medical technology.</p>
                    <p>Our team of dedicated healthcare professionals works tirelessly to ensure that every patient receives
                        the highest quality of care in a supportive and healing environment.</p>
                </div>
                <div class="col-md-6">
                    <div class="bg-info text-white d-flex align-items-center justify-content-center rounded"
                        style="height: 300px;">
                        <span>Our Mission Image</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="team" class="section bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Our Medical Team</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card text-center h-100">
                        <div class="card-img-top bg-dark text-white d-flex align-items-center justify-content-center"
                            style="height: 250px;">
                            <span>Dr. John Smith<br>Chief Physician</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Dr. John Smith</h5>
                            <p class="card-text">Chief Physician<br>Internal Medicine</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-center h-100">
                        <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center"
                            style="height: 250px;">
                            <span>Nurse Sarah Johnson<br>Head Nurse</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Nurse Sarah Johnson</h5>
                            <p class="card-text">Head Nurse<br>Emergency Care</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-center h-100">
                        <div class="card-img-top bg-primary text-white d-flex align-items-center justify-content-center"
                            style="height: 250px;">
                            <span>Receptionist Mike Davis<br>Patient Coordinator</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Receptionist Mike Davis</h5>
                            <p class="card-text">Patient Coordinator<br>Front Desk</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="appointment" class="section">
        <div class="container text-center">
            <h2>Book Your Appointment</h2>
            <p>Schedule your visit with our healthcare professionals today.</p>
            <a href="{{ route('patient.appointment.dashboard') }}" class="btn btn-primary btn-lg">Book Appointment</a>
        </div>
    </section>

    <section id="contact" class="section bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Contact Information</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Address</h5>
                    <p>The Medcare Medical Hospital <br>Gujranwala City, HC 12345</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Phone</h5>
                    <p>(042) 456-7890<br>(042) 456-7891</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Email</h5>
                    <p>medcarehospital@clinic.com<br>appointments@medcareclinic.com</p>
                </div>
            </div>
        </div>
    </section>

    <style>
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }

        .section {
            padding: 80px 0;
        }

        .card {
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection
