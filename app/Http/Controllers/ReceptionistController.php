<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReceptionistController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 3) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $pendingAppointments = Appointment::where('status', 'in_progress')
            ->where('sent_to_doctor', false)
            ->with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'asc')
            ->get();
        $sentAppointments = Appointment::where('status', 'scheduled')
            ->where('sent_to_doctor', true)
            ->with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('dashboard.receptionist', compact('pendingAppointments', 'sentAppointments'));
    }

    public function sendToDoctor($appointmentId)
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 3) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        try {
            $appointment = Appointment::findOrFail($appointmentId);

            if ($appointment->status !== 'in_progress') {
                return back()->withErrors(['error' => 'Only In Progress appointments can be sent to doctor.']);
            }

            if ($appointment->sent_to_doctor) {
                return back()->withErrors(['error' => 'Appointment has already been sent to doctor.']);
            }

            // Mark as sent to doctor and set status to scheduled
            $appointment->update(['sent_to_doctor' => true, 'status' => 'scheduled']);

            Log::info('Appointment sent to doctor by receptionist', [
                'appointment_id' => $appointment->id,
                'receptionist_id' => $user->id,
                'doctor_id' => $appointment->doctor_id
            ]);

            // Trigger notification
            $appointment->patient->notify(new \App\Notifications\AppointmentUpdated($appointment, 'scheduled'));

            return back()->with('success', 'Appointment successfully sent to doctor.');
        } catch (\Exception $e) {
            Log::error('Error sending appointment to doctor: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to send appointment to doctor.']);
        }
    }
}
