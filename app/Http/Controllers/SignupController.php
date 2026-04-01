<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SignupController extends Controller
{
    public function terms()
    {
        // COMPLETELY BYPASS BLADE VIEWS
        return $this->getTermsHTML();
    }

    public function acceptTerms(Request $request)
    {
        $request->validate([
            'terms_accepted' => 'required|accepted',
        ]);

        Session::put('terms_accepted', true);
        return redirect()->route('signup.prerequisites');
    }

    public function prerequisites()
    {
        if (!Session::has('terms_accepted')) {
            return redirect()->route('signup.terms')->with('error', 'Please accept terms first.');
        }

        return $this->getPrerequisitesHTML();
    }

    public function confirmPrerequisites(Request $request)
    {
        Session::put('prerequisites_viewed', true);
        return redirect()->route('signup.age-verification');
    }

    public function ageVerification()
    {
        if (!Session::has('prerequisites_viewed')) {
            return redirect()->route('signup.prerequisites')->with('error', 'Please review prerequisites first.');
        }

        return $this->getAgeVerificationHTML();
    }
    // public function submitAgeVerification(Request $request)
    // {
    //     $request->validate([
    //         'age_verification' => 'required|in:adult,guardian',
    //     ]);

    //     Session::put('age_verified', $request->age_verification);

    //     // Redirect to actual signup form instead of patient.signup (which goes back to terms)
    //     return redirect()->route('patient.signup.form');
    // }
public function submitAgeVerification(Request $request)
{
    $request->validate([
        'age_verification' => 'required|in:adult,guardian',
    ]);

    Session::put('age_verified', $request->age_verification);

    Log::info('Age verification completed, redirecting to signup form');

    // Ensure this matches your route name
    return redirect()->route('patient.signup.form');
}

    // Back routes
    public function backToTerms()
    {
        Session::forget(['terms_accepted', 'prerequisites_viewed', 'age_verified']);
        return redirect()->route('signup.terms');
    }

    public function backToPrerequisites()
    {
        Session::forget(['prerequisites_viewed', 'age_verified']);
        return redirect()->route('signup.prerequisites');
    }


    private function getTermsHTML()
    {
        return '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions - OurPhoneMD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("https://img.freepik.com/free-photo/young-handsome-physician-medical-robe-with-stethoscope_1303-17818.jpg?t=st=1746139347~exp=1746142947~hmac=c73e58a65605a23c92ca600973692cc8372440233a35d7e4552b6ae9d820da4c&w=1060");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
        .navbar-brand { font-weight: bold; font-size: 24px; }

        .card {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .bg-light {
            background-color: rgba(248, 249, 250, 0.8) !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light shadow-sm" style="background-color: rgba(255, 255, 255, 0.95);">
        <div class="container">
            <a class="navbar-brand" href="/">
                <span style="color: #3EA293;">OurPhone</span><span style="color: #FF3B3B;">MD</span>
            </a>
            <a href="/patient/signin" class="btn btn-outline-primary">Login</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4" style="color: #3EA293;">Terms & Conditions</h2>

                        <div class="bg-light p-4 rounded mb-4">
                            <h5>OurPhoneMD Terms of Service</h5>
                            <p>Welcome to OurPhoneMD. By accessing our services, you agree to be bound by these Terms and Conditions.</p>

                            <h6>1. Medical Services</h6>
                            <p>OurPhoneMD provides telemedicine consultations and related healthcare services.</p>

                            <h6>2. Privacy Policy</h6>
                            <p>We are committed to protecting your privacy. All personal and medical information is handled in accordance with HIPAA regulations.</p>

                            <h6>3. User Responsibilities</h6>
                            <p>You agree to provide accurate, complete, and updated information about yourself.</p>
                             <h6>4. Medical Emergencies</h6>
                            <p>OurPhoneMD is not designed for emergency situations. If you are experiencing a medical emergency, please dial 911 or go to your nearest emergency room immediately.</p>
                             <h6>5.Limitation of Liability </h6>
                            <p>OurPhoneMD and its healthcare providers are not liable for any advice, diagnosis, or treatment provided through our platform, except as required by applicable law.</p>

                        </div>

                        <form action="/signup/accept-terms" method="POST">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="terms_accepted" id="terms_accepted" required>
                                <label class="form-check-label" for="terms_accepted">
                                    I have read and accept the terms and conditions
                                </label>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="window.location.href=\'/\'">Cancel</button>
                                <button type="submit" class="btn btn-primary" style="background-color: #3EA293; border: none;">Next</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4" style="background-color: rgba(255, 255, 255, 0.8); padding: 10px;">
        <p class="font-bold text-danger text-sm">CUSTOMER SUPPORT/APPOINTMENT BY PHONE</p>
        <p class="font-bold">(270) 769-0110</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
';
    }
    private function getPrerequisitesHTML()
    {
        return '
<!DOCTYPE html>
<html>
<head>
    <title>Prerequisites - OurPhoneMD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("https://img.freepik.com/free-photo/young-handsome-physician-medical-robe-with-stethoscope_1303-17818.jpg?t=st=1746139347~exp=1746142947~hmac=c73e58a65605a23c92ca600973692cc8372440233a35d7e4552b6ae9d820da4c&w=1060");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
        }
        .alert-info {
            background-color: rgba(13, 202, 240, 0.9) !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                <span style="color: #3EA293;">OurPhone</span><span style="color: #FF3B3B;">MD</span>
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4" style="color: #3EA293;">Prerequisites</h2>

                        <div class="alert alert-info">
                            <h5>Before moving forward, make sure you have these things:</h5>
                            <ul class="mb-0">
                                <li><strong>Access to Email/Text Messaging</strong></li>
                                <li><strong>Access to Insurance</strong> - Insurance Card Information</li>
                                <li><strong>Pharmacy Details</strong> - Name, Contact Number, Address</li>
                                <li><strong>Hospital Details</strong> - Name, Contact Number, Address</li>
                            </ul>
                        </div>

                        <form action="/signup/confirm-prerequisites" method="POST">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary" onclick="window.location.href=\'/signup/terms\'">Back</button>
                                <button type="submit" class="btn btn-primary" style="background-color: #3EA293; border: none;">I Have Everything Ready</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
';
    }
    private function getAgeVerificationHTML()
    {
        return '
<!DOCTYPE html>
<html>
<head>
    <title>Age Verification - OurPhoneMD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("https://img.freepik.com/free-photo/young-handsome-physician-medical-robe-with-stethoscope_1303-17818.jpg?t=st=1746139347~exp=1746142947~hmac=c73e58a65605a23c92ca600973692cc8372440233a35d7e4552b6ae9d820da4c&w=1060");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
        }
        .alert-warning {
            background-color: rgba(255, 193, 7, 0.9) !important;
        }
        .form-check {
            background-color: rgba(248, 249, 250, 0.8);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                <span style="color: #3EA293;">OurPhone</span><span style="color: #FF3B3B;">MD</span>
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4" style="color: #3EA293;">Age Verification</h2>

                        <p class="text-muted mb-4">Please select the option that best describes your situation:</p>

                        <form action="/signup/submit-age-verification" method="POST">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">

                            <div class="mb-4">
                                <div class="form-check mb-3 p-3 border rounded">
                                    <input class="form-check-input" type="radio" name="age_verification" value="adult" id="adult" required>
                                    <label class="form-check-label" for="adult">
                                        <strong>I am 18 years or older</strong><br>
                                        <small class="text-muted">I am registering for myself and can provide identification</small>
                                    </label>
                                </div>

                                <div class="form-check p-3 border rounded">
                                    <input class="form-check-input" type="radio" name="age_verification" value="guardian" id="guardian">
                                    <label class="form-check-label" for="guardian">
                                        <strong>I am a parent or legal guardian</strong><br>
                                        <small class="text-muted">I am registering on behalf of someone under 18 years old</small>
                                    </label>
                                </div>
                            </div>

                            <div class="alert alert-warning">
                                <strong>Important:</strong> Valid identification and/or legal guardianship documentation may be required during your first visit.
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="window.location.href=\'/signup/prerequisites\'">Back</button>
                                <button type="submit" class="btn btn-primary" style="background-color: #3EA293; border: none;">Next</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
';
    }
}
