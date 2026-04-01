<?php


namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{


    public function dashboard()
    {
        $doctor = Auth::user();
        $today = Carbon::today();

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with(['patient', 'familyMember'])
            ->get();

        $upcomingCount = $appointments->where('appointment_date', '>', $today)
            ->whereIn('status', ['confirmed', 'scheduled'])
            ->count();

        $finishedCount = $appointments->where('status', 'completed')->count();

        $unconfirmedCount = $appointments->where('status', 'in_progress')->count();

        $followUpCount = $appointments->where('priority', 'follow-up')->count();

        $walkInCount = $appointments->where('priority', 'urgent')->count();

        $cancelledCount = $appointments->where('status', 'cancelled')->count();

        $unfinishedCount = $appointments->where('appointment_date', '<', $today)
            ->where('status', 'confirmed')
            ->count();

        $todayAppointments = $appointments->where('appointment_date', $today->format('Y-m-d'));

        // Helper function to format appointments
        $formatAppointments = function($appointmentsData) {
            return $appointmentsData->map(function($apt) {
            $patientName = 'Patient';
            $appointmentType = 'self';
            $relationship = null;

            if ($apt->family_member_id && $apt->familyMember) {
                 $patientName = $apt->familyMember->first_name . ' ' . $apt->familyMember->last_name;
                 $appointmentType = 'family';
                 $relationship = $apt->familyMember->relationship;
            } elseif ($apt->patient) {
                 $patientName = $apt->patient->first_name . ' ' . $apt->patient->last_name;
            }

            return [
                'id' => $apt->id,
                'appointment_date' => $apt->appointment_date,
                'appointment_time' => $apt->appointment_time,
                'status' => $apt->status,
                'patient_name' => $patientName,
                'doctor_name' => $apt->doctor ? $apt->doctor->name : 'Doctor',
                'appointment_mode' => $apt->appointment_mode ?? 'in-person',
                'family_member_id' => $apt->family_member_id,
                'relationship' => $relationship,
                'appointment_type' => $appointmentType
            ];
        })->values();
        };

        // Get appointment data for calendar views
        $upcomingAppointments = $formatAppointments(Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', '>', $today)
            ->whereIn('status', ['confirmed', 'scheduled'])
            ->with(['patient', 'familyMember'])
            ->get());

        $finishedAppointments = $formatAppointments(Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'completed')
            ->with(['patient', 'familyMember'])
            ->get());

        $walkInAppointments = $formatAppointments(Appointment::where('doctor_id', $doctor->id)
            ->where('priority', 'urgent')
            ->with(['patient', 'familyMember'])
            ->get());

        $unconfirmedAppointments = $formatAppointments(Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'in_progress')
            ->with(['patient', 'familyMember'])
            ->get());

        $followUpAppointments = $formatAppointments(Appointment::where('doctor_id', $doctor->id)
            ->where('priority', 'follow-up')
            ->with(['patient', 'familyMember'])
            ->get());

        $cancelledAppointments = $formatAppointments(Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'cancelled')
            ->with(['patient', 'familyMember'])
            ->get());

        $unfinishedAppointments = $formatAppointments(Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', '<', $today)
            ->where('status', 'confirmed')
            ->with(['patient', 'familyMember'])
            ->get());

        return view('dashboard.doctor', compact(
            'doctor',
            'upcomingCount',
            'finishedCount',
            'unconfirmedCount',
            'followUpCount',
            'walkInCount',
            'cancelledCount',
            'unfinishedCount',
            'todayAppointments',
            'upcomingAppointments',
            'finishedAppointments',
            'walkInAppointments',
            'unconfirmedAppointments',
            'followUpAppointments',
            'cancelledAppointments',
            'unfinishedAppointments'
        ));
    }

//     public function dashboard()
//     {
//         $doctor = Auth::user();
//         $today = Carbon::today();

//         $appointments = Appointment::where('doctor_id', $doctor->id)
//             ->with('patient')
//             ->get();

//         $upcomingCount = $appointments->where('appointment_date', '>', $today)
//             ->where('status', 'confirmed')
//             ->count();

//         $finishedCount = $appointments->where('status', 'completed')->count();

//         $unconfirmedCount = $appointments->where('status', 'pending')->count();

//         $followUpCount = $appointments->where('priority', 'follow-up')->count();

//         $walkInCount = $appointments->where('type', 'walk-in')->count();

//         $cancelledCount = $appointments->where('status', 'cancelled')->count();

//         $unfinishedCount = $appointments->where('appointment_date', '<', $today)
//             ->where('status', 'confirmed')
//             ->count();

//         $todayAppointments = $appointments->where('appointment_date', $today->format('Y-m-d'));

//         return view('dashboard.doctor', compact(
//             'doctor',
//             'upcomingCount',
//             'finishedCount',
//             'unconfirmedCount',
//             'followUpCount',
//             'walkInCount',
//             'cancelledCount',
//             'unfinishedCount',
//             'todayAppointments'
//         ));
//     }



// namespace App\Http\Controllers;

// use App\Models\Appointment;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log;

// class DoctorController extends Controller
// {
//     public function dashboard()
//     {
//         $user = Auth::user();

//         // Check if user is authenticated and is a doctor
//         if (!$user || $user->role_id != 5) {
//             Log::warning('Unauthorized access to doctor dashboard', [
//                 'user_id' => $user ? $user->id : null,
//                 'role_id' => $user ? $user->role_id : null,
//                 'ip' => request()->ip()
//             ]);
//             return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
//         }

//         // Fetch appointments for this doctor that have been sent to doctor
//         $appointments = Appointment::where('doctor_id', $user->id)
//             ->where('sent_to_doctor', true)
//             ->with('patient')
//             ->orderBy('appointment_date', 'asc')
//             ->get();

//         Log::info('Doctor dashboard accessed', [
//             'doctor_id' => $user->id,
//             'doctor_name' => $user->name,
//             'appointments_count' => $appointments->count(),
//             'appointments' => $appointments->map(function ($app) {
//                 return [
//                     'id' => $app->id,
//                     'patient_id' => $app->patient_id,
//                     'date' => $app->appointment_date,
//                     'time' => $app->appointment_time,
//                     'status' => $app->status,
//                     'sent_to_doctor' => $app->sent_to_doctor
//                 ];
//             })->toArray()
//         ]);

//         return view('dashboard.doctor', compact('appointments'));
//     }

    public function showAppointmentDetail($id)
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        try {
            $appointment = Appointment::where('id', $id)
                ->where('doctor_id', $user->id)
                ->with(['patient', 'familyMember'])
                ->firstOrFail();

            // Fetch past notes for this patient (account holder)
            $pastNotes = \App\Models\PatientNote::where('patient_id', $appointment->patient_id)
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info('Doctor viewing appointment detail', [
                'doctor_id' => $user->id,
                'appointment_id' => $id
            ]);

            return view('doctor.appointment-detail', compact('appointment', 'pastNotes'));
        } catch (\Exception $e) {
            Log::error('Appointment detail error', [
                'doctor_id' => $user->id,
                'appointment_id' => $id,
                'error' => $e->getMessage()
            ]);
            return redirect('/doctor/dashboard')->withErrors(['error' => 'Appointment not found.']);
        }
    }

    /**
     * Show all patients assigned to this doctor (patients who have appointments with the doctor)
     */
    public function patients()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        // Patients who have had at least one appointment with this doctor
        $patients = Patient::whereHas('appointments', function($q) use ($user) {
            $q->where('doctor_id', $user->id);
        })->withCount(['appointments as appointments_with_doctor_count' => function($q) use ($user) {
            $q->where('doctor_id', $user->id);
        }])->orderBy('first_name')->get();

        return view('doctor.patients', compact('patients'));
    }

    /**
     * Show patient profile for a given patient id (doctor must be owner)
     */
    public function showPatient($id)
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $patient = Patient::with(['appointments' => function($q) use ($user){ $q->where('doctor_id', $user->id); }])->findOrFail($id);

        return view('doctor.patient-profile', compact('patient'));
    }

    /**
     * Show form to create a new patient (doctor)
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        return view('doctor.add-patient');
    }

    /**
     * Store a newly created patient by the doctor
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $rules = [
            'first_name' => ['required','string','max:255','regex:/^[A-Za-z\s]+$/'],
            'middle_name' => ['required','string','max:255','regex:/^[A-Za-z\s]+$/'],
            'last_name' => ['required','string','max:255','regex:/^[A-Za-z\s]+$/'],
            'email' => ['required','email','unique:patients,email'],
            'password' => ['required','string','min:6','regex:/^[A-Za-z0-9]+$/'],
            'contact_number' => ['required','string','max:50'],
            'secondary_contact' => ['required','string','max:50'],
            'date_of_birth' => ['required','date'],
            'gender' => ['required','string','max:20'],
            'address' => ['required','string'],
            'city' => ['required','string','max:100'],
            'state' => ['required','string','max:100'],
            'zip_code' => ['required','string','max:30'],
            'guardian_name' => ['required','string','max:255'],
            'profile_picture' => ['nullable','image','max:2048']
        ];

        $messages = [
            'required' => 'This field is required',
            'email.unique' => 'This email is already registered',
            'first_name.regex' => 'Special characters are not allowed',
            'middle_name.regex' => 'Special characters are not allowed',
            'last_name.regex' => 'Special characters are not allowed',
            'password.min' => 'Password must be at least 6 characters',
            'password.regex' => 'Special characters are not allowed in password',
        ];

        $data = $request->validate($rules, $messages);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('patients', 'public');
            $data['profile_picture'] = $path;
        }

        // Hash password (required)
        $data['password'] = bcrypt($data['password']);

        $patient = \App\Models\Patient::create($data);

        // Flash created patient data so it appears immediately in the patients list and redirect to dashboard
        return redirect()->route('doctor.dashboard')->with('new_patient', $patient->toArray())->with('success', 'Patient added successfully');
    }

    /**
     * AJAX: check if email already exists
     */
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        if(!$email) return response()->json(['exists' => false]);
        $exists = Patient::where('email', $email)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function confirmAppointment($id)
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        try {
            $appointment = Appointment::where('id', $id)
                ->where('doctor_id', $user->id)
                ->where('sent_to_doctor', true)
                ->firstOrFail();

            if ($appointment->status !== 'scheduled') {
                Log::warning('Attempt to confirm non-scheduled appointment', [
                    'doctor_id' => $user->id,
                    'appointment_id' => $id,
                    'status' => $appointment->status
                ]);
                return back()->withErrors(['error' => 'Only scheduled appointments can be confirmed.']);
            }

            $appointment->update(['status' => 'confirmed']);

            Log::info('Appointment confirmed', [
                'doctor_id' => $user->id,
                'appointment_id' => $id
            ]);

            // Trigger notification
            $appointment->patient->notify(new \App\Notifications\AppointmentUpdated($appointment, 'confirmed'));

            return back()->with('success', 'Appointment confirmed successfully.');
        } catch (\Exception $e) {
            Log::error('Appointment confirmation error', [
                'doctor_id' => $user->id,
                'appointment_id' => $id,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'Failed to confirm appointment.']);
        }
    }

    public function cancelAppointment($id)
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        try {
            $appointment = Appointment::where('id', $id)
                ->where('doctor_id', $user->id)
                ->where('sent_to_doctor', true)
                ->firstOrFail();

            if ($appointment->status !== 'scheduled') {
                Log::warning('Attempt to cancel non-scheduled appointment', [
                    'doctor_id' => $user->id,
                    'appointment_id' => $id,
                    'status' => $appointment->status
                ]);
                return back()->withErrors(['error' => 'Only scheduled appointments can be cancelled.']);
            }

            $appointment->update(['status' => 'cancelled']);

            Log::info('Appointment cancelled', [
                'doctor_id' => $user->id,
                'appointment_id' => $id
            ]);

            // Trigger notification
            $appointment->patient->notify(new \App\Notifications\AppointmentUpdated($appointment, 'cancelled'));

            return back()->with('success', 'Appointment cancelled successfully.');
        } catch (\Exception $e) {
            Log::error('Appointment cancellation error', [
                'doctor_id' => $user->id,
                'appointment_id' => $id,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'Failed to cancel appointment.']);
        }
    }

    public function upcomingAppointments()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $today = Carbon::today();
        $appointments = Appointment::where('doctor_id', $user->id)
            ->where('appointment_date', '>', $today)
            ->whereIn('status', ['confirmed', 'scheduled'])
            ->with('patient')
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('doctor.appointments.upcoming', compact('appointments'));
    }

    public function finishedAppointments()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $appointments = Appointment::where('doctor_id', $user->id)
            ->where('status', 'completed')
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('doctor.appointments.finished', compact('appointments'));
    }

    public function unconfirmedAppointments()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $appointments = Appointment::where('doctor_id', $user->id)
            ->where('status', 'in_progress')
            ->with('patient')
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('doctor.appointments.unconfirmed', compact('appointments'));
    }

    public function followUpAppointments()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $appointments = Appointment::where('doctor_id', $user->id)
            ->where('priority', 'follow-up')
            ->with('patient')
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('doctor.appointments.follow-up', compact('appointments'));
    }
public function walkInAppointments()
{
    $user = Auth::user();
    if (!$user || $user->role_id != 5) {
        return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
    }

    // OPTION 1: Use priority field (urgent = walk-in)
    $appointments = Appointment::where('doctor_id', $user->id)
        ->where('priority', 'urgent')
        ->with('patient')
        ->orderBy('appointment_date', 'desc')
        ->get();

    // OPTION 2: If you want to create walk-in appointments differently
    // $appointments = Appointment::where('doctor_id', $user->id)
    //     ->where('created_at', '>=', now()->subDay()) // Today's appointments
    //     ->where('status', 'pending') // Not confirmed yet
    //     ->with('patient')
    //     ->orderBy('created_at', 'desc')
    //     ->get();

    return view('doctor.appointments.walk-in', compact('appointments'));
}

    public function cancelledAppointments()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $appointments = Appointment::where('doctor_id', $user->id)
            ->where('status', 'cancelled')
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('doctor.appointments.cancelled', compact('appointments'));
    }

    public function unfinishedAppointments()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $today = Carbon::today();
        $appointments = Appointment::where('doctor_id', $user->id)
            ->where('appointment_date', '<', $today)
            ->where('status', 'confirmed')
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('doctor.appointments.unfinished', compact('appointments'));
    }
    public function patientAppointments($id)
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
             return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }
        $patient = Patient::findOrFail($id);
        
        $appointments = Appointment::where('patient_id', $id)
            ->where('doctor_id', $user->id)
            ->orderBy('appointment_date', 'desc')
            ->get();
            
        return view('doctor.patient-appointments', compact('patient', 'appointments'));
    }

    public function patientTransactions($id)
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
             return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }
        $patient = Patient::findOrFail($id);
        
        // Fetch transactions for this patient
        $transactions = \App\Models\Payment::where('patient_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('doctor.patient-transactions', compact('patient', 'transactions'));
    }
}
