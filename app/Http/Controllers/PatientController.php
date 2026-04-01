<?php

namespace App\Http\Controllers;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{

    public function homepage()
    {
        try {
            Log::info('Homepage accessed');
            return view('patient.homepage');
        } catch (\Exception $e) {
            Log::error('Homepage error: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }

    public function showSignIn()
    {
        return view('patient.signin');
    }

    public function signIn(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $patient = Patient::where('email', $request->email)->first();

            if (!$patient) {
                Log::warning('Patient sign-in attempt with non-existent email: ' . $request->email);
                return back()->withErrors(['error' => 'Invalid credentials.']);
            }

            if (!Hash::check($request->password, $patient->password)) {
                Log::warning('Patient sign-in attempt with wrong password for email: ' . $request->email);
                return back()->withErrors(['error' => 'Invalid credentials.']);
            }

            if (isset($patient->status) && $patient->status !== 'active') {
                Log::warning('Patient sign-in attempt for inactive account: ' . $request->email);
                return back()->withErrors(['error' => 'Your account is inactive. Please contact support.']);
            }

            if ($patient->email_verified_at === null) {
                Log::warning('Patient sign-in attempt with unverified email: ' . $request->email);
                return back()->withErrors(['error' => 'Please verify your email address before logging in.']);
            }

            Auth::guard('patient')->login($patient);

            Log::info('Patient signed in successfully: ' . $patient->email);

            return redirect()->route('patient.dashboard')->with('success', 'Welcome back!');
        } catch (\Exception $e) {
            Log::error('Patient sign-in error: ' . $e->getMessage());
            Log::error('Patient sign-in Trace: ' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Sign-in failed. Please try again. Error: ' . $e->getMessage()]);
        }
    }

    public function confirmReset($token)
    {
        try {
            $resetToken = PasswordResetToken::where('token', $token)->first();

            if (!$resetToken || $resetToken->created_at < now()->subMinutes(60)) {
                if ($resetToken) {
                    $resetToken->delete();
                }
                Log::warning('Invalid or expired patient reset token: ' . $token);
                return redirect()->route('patient.signin')->with('error', 'Invalid or expired reset link.');
            }

            $patient = Patient::where('email', $resetToken->email)->first();

            if (!$patient) {
                $resetToken->delete();
                Log::error('Patient not found for reset token: ' . $resetToken->email);
                return redirect()->route('patient.signin')->with('error', 'Account not found.');
            }

            if (!$resetToken->new_password) {
                $resetToken->delete();
                Log::error('No new password in reset token for patient: ' . $patient->email);
                return redirect()->route('patient.signin')->with('error', 'Invalid reset link.');
            }

            $patient->password = $resetToken->new_password;
            $patient->save();

            $resetToken->delete();

            Log::info('Patient password reset successful: ' . $patient->email);

            // Auto login after password reset
            Auth::guard('patient')->login($patient);

            return redirect()->route('patient.homepage')->with('success', 'Your password has been updated successfully. You are now logged in.');
        } catch (\Exception $e) {
            Log::error('Patient password reset confirmation error: ' . $e->getMessage());
            return redirect()->route('patient.signin')->with('success', 'Your password has been updated successfully. You are now logged in.');
        }
    }


    public function bookAppointment(Request $request)
    {
        Log::info('Book Appointment Request:', $request->all());

        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            Log::error('Patient not authenticated');
            return redirect()->route('patient.signin');
        }

        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'symptoms' => 'required|string|max:1000',
            'priority' => 'required|in:normal,urgent',
        ]);

        try {
            Log::info('Creating appointment for patient: ' . $patient->id);

            // Check if doctor already has an appointment at same time
            $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
                ->where('appointment_date', $request->appointment_date)
                ->where('appointment_time', $request->appointment_time)
                ->whereNotIn('status', ['cancelled'])
                ->first();

            if ($existingAppointment) {
                Log::warning('Doctor already has an appointment at this time');
                return back()->withErrors(['error' => 'This time slot is already booked for the selected doctor. Please choose a different time.']);
            }

            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor_id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'symptoms' => $request->symptoms,
                'priority' => $request->priority,
                'status' => 'in_progress',
                'token' => \Illuminate\Support\Str::random(24),
            ]);

            Log::info('Appointment created successfully: ' . $appointment->id);

            return redirect()->route('patient.appointment.dashboard')
                ->with('success', 'Your appointment has been booked successfully.');
        } catch (\Exception $e) {
            Log::error('Appointment booking error: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Failed to book appointment. Please try again. Error: ' . $e->getMessage()]);
        }
    }
    public function cancelAppointment($id)
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        try {
            $appointment = Appointment::where('id', $id)
                ->where('patient_id', $patient->id)
                ->firstOrFail();

            if ($appointment->status === 'confirmed') {
                return back()->withErrors(['error' => 'Cannot cancel confirmed appointment. Please contact hospital.']);
            }

            $appointment->update(['status' => 'cancelled']);

            return back()->with('success', 'Appointment cancelled successfully.');
        } catch (\Exception $e) {
            Log::error('Appointment cancellation error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to cancel appointment.']);
        }
    }

    public function dashboard()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        // Fetch counts
        $upcomingAppointmentsCount = Appointment::where('patient_id', $patient->id)
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->count();

        $familyMembersCount = FamilyMember::where('patient_id', $patient->id)->count();

        $completedVisitsCount = Appointment::where('patient_id', $patient->id)
            ->where('status', 'completed')
            ->count();

        // Initializing other counts to 0 for now as their logic/tables might differ
        $walkinAppointmentsCount = 0;
        // Fetch notes count
        $notesCount = \App\Models\PatientNote::where('patient_id', $patient->id)->count();

        // Fetch lists for calendar (needed for JS)
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('appointment_date', '>=', now()->toDateString())
            ->whereNotIn('status', ['cancelled'])
            ->with(['doctor'])
            ->get();

        $pastAppointments = Appointment::where('patient_id', $patient->id)
            ->where('appointment_date', '<', now()->toDateString())
            ->with(['doctor'])
            ->get();

        $completedVisits = Appointment::where('patient_id', $patient->id)
            ->where('status', 'completed')
            ->with(['doctor'])
            ->get();

        $walkinAppointments = [];
        $notes = \App\Models\PatientNote::where('patient_id', $patient->id)
            ->where('is_visible_to_patient', true)
            ->with('doctor')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('patient.dashboard', compact(
            'patient',
            'upcomingAppointmentsCount',
            'familyMembersCount',
            'completedVisitsCount',
            'walkinAppointmentsCount',
            'notesCount',
            'upcomingAppointments',
            'pastAppointments',
            'completedVisits',
            'walkinAppointments',
            'notes'
        ));
    }

    public function showProfile()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        return view('patient.profile', compact('patient'));
    }

    public function updateProfile(Request $request)
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        // Ensure $patient is a Patient model instance
        if (!$patient instanceof Patient) {
            Log::error('Patient is not a Patient model instance: ' . get_class($patient));
            return back()->withErrors(['error' => 'Authentication error. Please try logging in again.']);
        }

        $messages = [
            'first_name.required' => 'First name is required.',
            'first_name.regex' => 'Special characters and numbers are not allowed.',
            'last_name.required' => 'Last name is required.',
            'last_name.regex' => 'Special Characters and numbers are not allowed.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
            'cnic.required' => 'CNIC number is required.',
            'cnic.unique' => 'This CNIC is already registered.',
            'contact_number.required' => 'Contact number is required.',
            'emergency_contact.required' => 'Emergency contact is required.',
            'address.required' => 'Address is required.',
            'city.required' => 'City is required.',
            'state.required' => 'State is required.',
            'zip_code.required' => 'ZIP code is required.',
            'blood_group.required' => 'Please select your blood group.',
            'blood_group.in' => 'Please select a valid blood group.',
        ];

        $validator = Validator::make($request->all(), [
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'email' => 'required|string|email|max:255|unique:patients,email,' . $patient->id,
            'contact_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date|before:today',
            'cnic' => 'required|string|max:15|unique:patients,cnic,' . $patient->id,
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'gender' => 'nullable|in:male,female,other',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'emergency_contact' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'medical_history' => 'nullable|string|max:1000',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $dateOfBirth = new \DateTime($request->date_of_birth);
            $today = new \DateTime();
            $age = $today->diff($dateOfBirth)->y;

            // Use fill() and save() instead of update() to be more explicit
            $patient->fill([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'date_of_birth' => $request->date_of_birth,
                'age' => $age,
                'cnic' => $request->cnic,
                'blood_group' => $request->blood_group,
                'gender' => $request->gender,
                'marital_status' => $request->marital_status,
                'emergency_contact' => $request->emergency_contact,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'medical_history' => $request->medical_history,
            ]);

            $patient->save();

            return redirect()->back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            Log::error('Patient profile update error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update profile. Please try again.']);
        }
    }

    public function visits()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        return view('patient.visits');
    }

    public function walkin()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        return view('patient.walkin');
    }

    public function notes()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        // Fetch notes visible to patient
        // Include relationships: doctor (User), appointment -> familyMember
        $notes = \App\Models\PatientNote::where('patient_id', $patient->id)
            ->where('is_visible_to_patient', true)
            ->with(['doctor', 'appointment.familyMember'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('patient.notes', compact('patient', 'notes'));
    }

    public function showForgotPasswordForm()
    {
        return view('patient.forgot-password');
    }

    public function familyMember()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        return view('patient.family-member');
    }

    public function showAppointmentDetail($id)
    {
        $doctor = Auth::user();
        if (!$doctor || $doctor->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        try {
            $appointment = Appointment::where('id', $id)
                ->where('doctor_id', $doctor->id)
                ->where('sent_to_doctor', true)
                ->with('patient')
                ->firstOrFail();

            return view('doctor.appointment-detail', compact('appointment'));
        } catch (\Exception $e) {
            Log::error('Appointment detail error: ' . $e->getMessage());
            return redirect('/doctor/dashboard')->withErrors(['error' => 'Appointment not found.']);
        }
    }
    public function confirmAppointment($id)
    {
        $doctor = Auth::user();
        if (!$doctor || $doctor->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        try {
            $appointment = Appointment::where('id', $id)
                ->where('doctor_id', $doctor->id)
                ->where('sent_to_doctor', true)
                ->firstOrFail();

            if ($appointment->status !== 'pending') {
                return back()->withErrors(['error' => 'Only pending appointments can be confirmed.']);
            }

            $appointment->update(['status' => 'confirmed']);

            return back()->with('success', 'Appointment confirmed successfully.');
        } catch (\Exception $e) {
            Log::error('Appointment confirmation error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to confirm appointment.']);
        }
    }

    // Appointment Wizard Methods
    public function wizardStep1()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        // Clear any existing wizard session data
        session()->forget(['appointment_wizard']);

        return view('patient.appointments.wizard-step1');
    }

    public function processWizardStep1(Request $request)
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        $request->validate([
            'is_adhd_appointment' => 'required|in:0,1'
        ]);

        // Store step 1 data in session
        session(['appointment_wizard.step1' => [
            'is_adhd_appointment' => $request->is_adhd_appointment
        ]]);

        return redirect()->route('patient.appointments.wizard.step2');
    }

    public function wizardStep2()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        // Check if step 1 is completed
        if (!session()->has('appointment_wizard.step1')) {
            return redirect()->route('patient.appointments.wizard.step1');
        }

        $wizardData = session('appointment_wizard');
        $doctors = User::where('role_id', 5)->where('status', 'active')->get();
        $familyMembers = FamilyMember::where('patient_id', $patient->id)->get();

        return view('patient.appointments.wizard-step2', compact('doctors', 'wizardData', 'familyMembers'));
    }

    public function processWizardStep2(Request $request)
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        // Check if step 1 is completed
        if (!session()->has('appointment_wizard.step1')) {
            return redirect()->route('patient.appointments.wizard.step1');
        }

        $request->validate([
            'patient_selection' => 'required|string'
        ]);

        $patientSelection = $request->patient_selection;
        $selectedMember = null;

        // Prepare selected member info (without database queries)
        if ($patientSelection === 'self') {
            $selectedMember = [
                'type' => 'self',
                'first_name' => $patient->first_name,
                'last_name' => $patient->last_name,
            ];
        } elseif (str_starts_with($patientSelection, 'family_')) {
            // For family members, just store the ID - we'll look up details if needed later
            $familyMemberId = str_replace('family_', '', $patientSelection);
            $selectedMember = [
                'type' => 'family',
                'family_member_id' => $familyMemberId,
            ];
        }

        // Store step 2 data in session
        session(['appointment_wizard.step2' => [
            'patient_selection' => $patientSelection,
            'selected_member' => $selectedMember
        ]]);

        return redirect()->route('patient.appointments.wizard.step3');
    }

    public function wizardStep3()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        // Check if previous steps are completed
        if (!session()->has('appointment_wizard.step1') || !session()->has('appointment_wizard.step2')) {
            return redirect()->route('patient.appointments.wizard.step1');
        }

        $wizardData = session('appointment_wizard');

        // Get selected member from session (may contain only an ID for family members)
        $selectedMember = $wizardData['step2']['selected_member'] ?? null;

        // If a family member was selected but only an ID was stored, attempt to load details safely
        if ($selectedMember && isset($selectedMember['type']) && $selectedMember['type'] === 'family') {
            $familyMemberId = $selectedMember['family_member_id'] ?? null;
            if ($familyMemberId) {
                try {
                    $fm = FamilyMember::find($familyMemberId);
                    if ($fm) {
                        $selectedMember = [
                            'type' => 'family',
                            'family_member_id' => $fm->id,
                            'first_name' => $fm->first_name,
                            'last_name' => $fm->last_name,
                            'relationship' => $fm->relationship,
                        ];
                    } else {
                        // family member not found — fall back to null so view shows patient info
                        $selectedMember = null;
                    }
                } catch (\Exception $e) {
                    // Log and continue with null to avoid crashing the page when DB is unavailable
                    Log::error('Failed to load family member for appointment wizard: ' . $e->getMessage());
                    $selectedMember = null;
                }
            } else {
                $selectedMember = null;
            }
        }

        // Use raw query to avoid Eloquent ORM overhead that triggers Xdebug infinite loop
        try {
            $doctors = DB::select("SELECT id, name FROM users WHERE role_id = 5 AND status = 'active'");
            $doctors = collect($doctors)->map(function($doc) {
                return (object)$doc;
            })->toArray();
        } catch (\Exception $e) {
            $doctors = [];
            Log::error('Failed to load doctors for appointment wizard step3: ' . $e->getMessage());
        }

        return view('patient.appointments.wizard-step3', compact('wizardData', 'doctors', 'selectedMember'));
    }

    public function processWizardStep3(Request $request)
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        // Check if all steps are completed
        if (!session()->has('appointment_wizard.step1') || !session()->has('appointment_wizard.step2')) {
            return redirect()->route('patient.appointments.wizard.step1');
        }

        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'appointment_mode' => 'required|in:in-person,telemedicine',
            'symptoms' => 'required|string|max:1000'
        ]);

        $doctor = User::findOrFail($request->doctor_id);

        // Store step 3 data in session
        session(['appointment_wizard.step3' => [
            'doctor_id' => $request->doctor_id,
            'doctor_name' => $doctor->name,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'appointment_mode' => $request->appointment_mode,
            'symptoms' => $request->symptoms
        ]]);

        return redirect()->route('patient.appointments.wizard.step4');
    }

    public function wizardStep4()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        // Check if all steps are completed
        if (!session()->has('appointment_wizard.step1') || !session()->has('appointment_wizard.step2') || !session()->has('appointment_wizard.step3')) {
            return redirect()->route('patient.appointments.wizard.step1');
        }

        $wizardData = session('appointment_wizard');

        return view('patient.appointments.wizard-step4', compact('wizardData'));
    }

    public function processWizardStep4(Request $request)
    {
        // This method is now only for displaying step 4 form
        // Appointment creation happens in PatientPaymentController@pay after successful payment
        // This is a placeholder to prevent direct POST submissions
        return redirect()->route('patient.appointments.wizard.step4');
    }
    public function processPayment(Request $request)
    {
        try {
            // Stripe secret key set کریں
            Stripe::setApiKey(config('services.stripe.secret'));

            // Request سے data لیں
            $token = $request->token;
            $amount = $request->amount; // cents میں ہوتا ہے، e.g. 10000 = $100
            $currency = $request->currency ?? 'usd';
            $description = $request->description ?? 'Appointment Payment';

            // Stripe charge create کریں
            $charge = Charge::create([
                'amount' => $amount,
                'currency' => $currency,
                'description' => $description,
                'source' => $token,
            ]);


            if ($charge->status === 'succeeded') {
                return response()->json(['success' => true, 'message' => 'Payment successful!']);
            } else {
                return response()->json(['success' => false, 'error' => 'Payment not completed.']);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('patient')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Log::info('Patient logged out successfully');

            return redirect()->route('patient.signin')->with('success', 'Logged out successfully.');
        } catch (\Exception $e) {
            Log::error('Patient logout error: ' . $e->getMessage());
            return redirect()->route('patient.signin')->with('error', 'Logout failed.');
        }
    }

    public function verifyEmail($token)
    {
        try {
            $patient = Patient::where('verification_token', $token)->first();

            if (!$patient) {
                Log::warning('Invalid email verification token: ' . $token);
                return redirect()->route('patient.signin')->with('error', 'Invalid verification link.');
            }

            if ($patient->email_verified_at) {
                Log::info('Patient email already verified: ' . $patient->email);
                return redirect()->route('patient.signin')->with('info', 'Email already verified.');
            }

            $patient->email_verified_at = now();
            $patient->verification_token = null;
            $patient->save();

            Log::info('Patient email verified: ' . $patient->email);

            return redirect()->route('patient.signin')->with('success', 'Email verified successfully. You can now sign in.');
        } catch (\Exception $e) {
            Log::error('Patient email verification error: ' . $e->getMessage());
            return redirect()->route('patient.signin')->with('error', 'Email verification failed.');
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:patients,email',
                'new_password' => 'required|min:6|same:confirm_password',
                'confirm_password' => 'required'
            ]);

            $patient = Patient::where('email', $request->email)->first();

            // Delete old reset tokens
            PasswordResetToken::where('email', $patient->email)->delete();

            // Generate reset token
            $resetToken = PasswordResetToken::create([
                'email' => $patient->email,
                'token' => \Illuminate\Support\Str::random(64),
                'new_password' => Hash::make($request->new_password),
                'created_at' => now(),
            ]);

            // Send email
            Mail::send('emails.patient_reset_password', ['patient' => $patient, 'token' => $resetToken->token], function($message) use ($patient) {
                $message->to($patient->email);
                $message->subject('Reset Your Password - OurPhoneMD');
            });

            Log::info('Password reset email sent for patient: ' . $patient->email);

            return redirect()->route('patient.forgot.password.form')->with('success', 'Password reset link sent to your email.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Patient forgot password error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to send reset link. Please try again.']);
        }
    }

    public function showSignupForm()
    {
        return view('patient.signup');
    }

    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'email' => 'required|email|unique:patients,email',
            'password' => 'required|min:8|confirmed',
            'contact_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date|before:today',
            'cnic' => 'required|string|max:15|unique:patients,cnic',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'gender' => 'required|in:male,female',
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'emergency_contact' => 'required|string|max:20',
        ], [
            'first_name.regex' => 'Special characters and numbers are not allowed.',
            'last_name.regex' => 'Special characters and numbers are not allowed.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $dateOfBirth = new \DateTime($request->date_of_birth);
            $today = new \DateTime();
            $age = $today->diff($dateOfBirth)->y;

            $patient = Patient::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'contact_number' => $request->contact_number,
                'date_of_birth' => $request->date_of_birth,
                'age' => $age,
                'cnic' => $request->cnic,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'verification_token' => \Illuminate\Support\Str::random(64),
                'status' => 'active',
                'gender' => $request->gender,
                'blood_group' => $request->blood_group,
                'marital_status' => $request->marital_status,
                'emergency_contact' => $request->emergency_contact,
                'medical_history' => $request->medical_history,
            ]);

            Log::info('Patient registered successfully: ' . $patient->email);

            \Illuminate\Support\Facades\Mail::send('emails.patient_verify', ['patient' => $patient, 'token' => $patient->verification_token], function($message) use ($patient) {
                $message->to($patient->email);
                $message->subject('Verify Your Email Address');
            });

            return redirect()->route('patient.signin')->with('success', 'Account created successfully. Please check your email for verification.');
        } catch (\Exception $e) {
            Log::error('Patient signup error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    public function appointmentDashboard()
    {
        Log::info('Entering Appointment Dashboard. URL: ' . request()->fullUrl());
        
        // Handle persistent success message from payment redirect
        if (session()->has('success_message')) {
            $msg = session()->get('success_message');
            session()->flash('success', $msg);
            session()->forget('success_message');
            Log::info('Persistent success message moved to flash: ' . $msg);
        }
        
        Log::info('Dashboard Session Data:', session()->all());
        
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        try {
            $appointments = Appointment::where('patient_id', $patient->id)
                ->where('appointment_date', '>=', now()->toDateString())
                ->with(['doctor', 'familyMember', 'payment'])
                ->orderBy('appointment_date', 'asc')
                ->orderBy('appointment_time', 'asc')
                ->get();

            return view('patient.appointment-dashboard', compact('appointments'));
        } catch (\Exception $e) {
            Log::error('Appointment dashboard error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to load appointments.']);
        }
    }

    public function appointmentDetails($token)
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        try {
            $appointment = Appointment::where('token', $token)
                ->where('patient_id', $patient->id)
                ->with(['doctor', 'patientNotes' => function($query) {
                    $query->orderBy('created_at', 'desc');
                }])
                ->firstOrFail();

            return view('patient.appointment-details', compact('appointment'));
        } catch (\Exception $e) {
            Log::error('Appointment details error: ' . $e->getMessage());
            return redirect()->route('patient.appointment.dashboard')->withErrors(['error' => 'Appointment not found.']);
        }
    }

    public function insurance()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        return view('patient.insurance');
    }

    public function faqs()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        return view('patient.faqs');
    }

    public function contactUs()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        return view('patient.contact-us');
    }
}

