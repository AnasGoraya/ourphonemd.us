@extends('layouts.patient')

@section('title', 'FAQs - OurPhoneMD')

@section('content')
<div class="container mt-5" style="font-weight: 500;">
    <!-- New Cards Section -->
     <h2 class="mb-4" style="color: rgb(87, 165, 150); font-weight: 700;">Frequently Asked Questions</h2>
    <p class="text-muted mb-4">Find answers to common questions about our telemedicine services</p>

    <!-- Search Bar -->
    <div class="mb-4">
        <div class="input-group" style="max-width: 500px;">
            <span class="input-group-text" style="background-color: #f3f4f6; border: 1px solid #d1d5db;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #9ca3af;">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
            </span>
            <input type="text" class="form-control" id="faqSearch" placeholder="Search for questions or keywords..." style="border: 1px solid #d1d5db; font-size: 14px;">
        </div>
    </div>


    <div class="accordion" id="faqAccordion">
        <!-- FAQ 1 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading1">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas me-2"></i>How do I book an appointment?
                    </button>
                </h5>
            </div>
            <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    You can book an appointment by logging into your patient dashboard and clicking on "Appointments". Follow the step-by-step wizard to select your preferred doctor, date, time, and provide necessary medical information.
                </div>
            </div>
        </div>

        <!-- FAQ 2 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading2">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas me-2"></i>What should I bring to my appointment?
                    </button>
                </h5>
            </div>
            <div id="collapse2" class="collapse" aria-labelledby="heading2" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    Please bring your ID, insurance card, any current medications, and a list of questions you may have for your doctor. If you have any recent test results or medical records, bring those as well.
                </div>
            </div>
        </div>

        <!-- FAQ 3 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading3">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas me-2"></i>How do I cancel or reschedule an appointment?
                    </button>
                </h5>
            </div>
            <div id="collapse3" class="collapse" aria-labelledby="heading3" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    You can cancel or reschedule appointments through your patient dashboard under the "Appointments" section. Please provide at least 24 hours notice for cancellations to avoid any fees.
                </div>
            </div>
        </div>

        <!-- FAQ 4 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading4">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas me-2"></i>What are your clinic hours?
                    </button>
                </h5>
            </div>
            <div id="collapse4" class="collapse" aria-labelledby="heading4" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    Our clinic is open Monday through Friday from 9:00 AM to 5:00 PM, and Saturday from 9:00 AM to 1:00 PM. We are closed on Sundays and major holidays.
                </div>
            </div>
        </div>

        <!-- FAQ 5 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading5">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas me-2"></i>Do you accept walk-in patients?
                    </button>
                </h5>
            </div>
            <div id="collapse5" class="collapse" aria-labelledby="heading5" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    Yes, we accept walk-in patients for urgent care needs. However, scheduled appointments are preferred for better service. Walk-in patients may experience longer wait times.
                </div>
            </div>
        </div>

        <!-- FAQ 6 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading6">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas me-2"></i>How do I access my medical records?
                    </button>
                </h5>
            </div>
            <div id="collapse6" class="collapse" aria-labelledby="heading6" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    You can access your medical records through your patient dashboard under the "Profile" section. All records are securely stored and can be downloaded as PDF files.
                </div>
            </div>
        </div>

        <!-- FAQ 7 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading7">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas me-2"></i>What insurance plans do you accept?
                    </button>
                </h5>
            </div>
            <div id="collapse7" class="collapse" aria-labelledby="heading7" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    We accept most major insurance plans including Blue Cross Blue Shield, Aetna, Cigna, United Healthcare, and Medicare. Please contact our office to verify your specific coverage.
                </div>
            </div>
        </div>

        <!-- FAQ 8 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading8">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas me-2"></i>How do I refill my prescriptions?
                    </button>
                </h5>
            </div>
            <div id="collapse8" class="collapse" aria-labelledby="heading8" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    Prescription refills can be requested through your patient dashboard or by calling our pharmacy at (555) 123-4567. Please allow 24-48 hours for processing.
                </div>
            </div>
        </div>

        <!-- FAQ 9 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading9">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas me-2"></i>What should I do in case of an emergency?
                    </button>
                </h5>
            </div>
            <div id="collapse9" class="collapse" aria-labelledby="heading9" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    In case of a medical emergency, please call 911 immediately or go to the nearest emergency room. Our clinic handles non-emergency medical care only.
                </div>
            </div>
        </div>

        <!-- FAQ 10 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading10">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="false" aria-controls="collapse10" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas me-2"></i>How do I update my contact information?
                    </button>
                </h5>
            </div>
            <div id="collapse10" class="collapse" aria-labelledby="heading10" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    You can update your contact information through your patient dashboard under the "Profile" section. Changes will be reflected in our system immediately.
                </div>
            </div>
        </div>

        <!-- FAQ 11 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading11">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas me-2"></i>Do you offer telemedicine services?
                    </button>
                </h5>
            </div>
            <div id="collapse11" class="collapse" aria-labelledby="heading11" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    Yes, we offer telemedicine consultations for follow-up visits and minor concerns. You can schedule a virtual appointment through your patient dashboard.
                </div>
            </div>
        </div>

        <!-- FAQ 12 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading12">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas me-2"></i>What languages do your doctors speak?
                    </button>
                </h5>
            </div>
            <div id="collapse12" class="collapse" aria-labelledby="heading12" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    Our doctors speak English, Spanish, and some also speak Arabic and Hindi. Translation services are available for other languages upon request.
                </div>
            </div>
        </div>

        <!-- FAQ 13 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading13">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse13" aria-expanded="false" aria-controls="collapse13" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas  me-2"></i>How do I prepare for lab tests?
                    </button>
                </h5>
            </div>
            <div id="collapse13" class="collapse" aria-labelledby="heading13" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    Preparation instructions vary by test. Your doctor will provide specific instructions when ordering lab work. Generally, some tests require fasting, while others have no special preparation.
                </div>
            </div>
        </div>

        <!-- FAQ 14 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading14">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse14" aria-expanded="false" aria-controls="collapse14" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas me-2"></i>Do you offer vaccination services?
                    </button>
                </h5>
            </div>
            <div id="collapse14" class="collapse" aria-labelledby="heading14" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    Yes, we offer a wide range of vaccinations including flu shots, COVID-19 vaccines, and routine childhood immunizations. Please call to schedule your vaccination appointment.
                </div>
            </div>
        </div>

        <!-- FAQ 15 -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header" id="heading15">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse15" aria-expanded="false" aria-controls="collapse15" style="color: #77BBC1; font-weight: 600;">
                        <i class="fas me-2"></i>How do I request a referral to a specialist?
                    </button>
                </h5>
            </div>
            <div id="collapse15" class="collapse" aria-labelledby="heading15" data-bs-parent="#faqAccordion">
                <div class="card-body">
                    Your primary care physician can provide referrals to specialists when medically necessary. Please discuss your needs with your doctor during your appointment, and they will assist with the referral process.
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 p-4 bg-light rounded" style="font-weight: 500;">
        <h5 style="color: rgb(87, 165, 150); font-weight: 700;">Still have questions?</h5>
        <p class="mb-3">If you couldn't find the answer to your question, please don't hesitate to contact us:</p>
        <div class="row">
            <div class="col-md-6">
                <p><i class="fas fa-phone text-success me-2"></i><strong>Phone:</strong> (555) 123-4567</p>
                <p><i class="fas fa-envelope text-primary me-2"></i><strong>Email:</strong> info@ourphonemd.com</p>
            </div>
            <div class="col-md-6">
                <p><i class="fas fa-clock text-warning me-2"></i><strong>Hours:</strong> Mon-Fri 9AM-5PM</p>
                <p><i class="fas fa-map-marker-alt text-danger me-2"></i><strong>Address:</strong> 123 Medical Center Dr, City, State 12345</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
