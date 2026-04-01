<?php

namespace App\Http\Controllers;

use App\Models\VideoConsultation;
use App\Services\VideoCallService;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Patient; // Add Patient model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\IncomingVideoCall;
use App\Events\CallAccepted;
use App\Events\CallDeclined;
use App\Events\CallEnded; // Assume these events will be created
use Illuminate\Support\Facades\Log;

class VideoCallController extends Controller
{
    protected $videoService;

    public function __construct(VideoCallService $videoService)
    {
        $this->videoService = $videoService;
    }

    /**
     * Start a video call (Doctor)
     */
    public function startCall(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
        ]);

        $doctor = Auth::user();
        $patientId = $request->patient_id;
        $appointmentId = $request->appointment_id;

        // 1. Create Room via Service
        $roomData = $this->videoService->createRoom($appointmentId);

        // 2. Create Database Record
        $consultation = VideoConsultation::create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patientId,
            'appointment_id' => $appointmentId,
            'room_name' => $roomData['name'],
            'provider_room_id' => $roomData['id'], // or ID from provider
            'status' => 'ringing',
            'meta_data' => json_encode($roomData), // Store full response if needed
        ]);

        // 3. Trigger Real-Time Event to Patient
        event(new IncomingVideoCall($consultation)); 
        
        // Trigger internal notification
        $patient = Patient::find($patientId);
        if ($patient) {
            $patient->notify(new \App\Notifications\IncomingVideoCall($consultation));
        } 
        Log::info("Call started by Dr. {$doctor->name} for Patient ID {$patientId}. Room: {$consultation->room_name}");

        return response()->json([
            'success' => true,
            'call_id' => $consultation->id,
            'room_name' => $consultation->room_name,
            'status' => 'ringing'
        ]);
    }

    /**
     * Join a call (Patient or Doctor)
     */
    public function joinCall(Request $request, $id)
    {
        $consultation = VideoConsultation::findOrFail($id);
        $user = Auth::user(); // Could be doctor (User) or patient (Patient guard)
        
        // If Auth::user() is null, try patient guard
        if (!$user) {
             $user = Auth::guard('patient')->user();
        }

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Authorization Check
        $isDoctor = $user instanceof User && $user->id === $consultation->doctor_id;
        $isPatient = $user instanceof Patient && $user->id === $consultation->patient_id;

        if (!$isDoctor && !$isPatient) {
            return response()->json(['error' => 'Unauthorized access to this call'], 403);
        }

        // Generate Token
        $token = $this->videoService->generateToken(
            $consultation->room_name, 
            $user->name ?? ($user->first_name . ' ' . $user->last_name), 
            $isDoctor
        );

        // If patient joins, update status
        if ($isPatient && $consultation->status === 'ringing') {
            $consultation->update(['status' => 'in_progress', 'started_at' => now()]);
            // event(new CallAccepted($consultation));
        }

        return response()->json([
            'success' => true,
            'token' => $token,
            'room_url' => json_decode($consultation->meta_data)->url ?? '', // Provide URL if using prebuilt UI
            'room_name' => $consultation->room_name
        ]);
    }

    /**
     * Decline call (Patient)
     */
    public function declineCall($id)
    {
        $consultation = VideoConsultation::findOrFail($id);
        // Authorization check...
        
        $consultation->update(['status' => 'declined']);
        // event(new CallDeclined($consultation));

        return response()->json(['success' => true]);
    }

    /**
     * End call
     */
    public function endCall($id)
    {
        $consultation = VideoConsultation::findOrFail($id);
        $consultation->update([
            'status' => 'completed',
            'ended_at' => now(),
            // Calculate duration...
        ]);
        // event(new CallEnded($consultation));

        return response()->json(['success' => true]);
    }

    /**
     * Poll for incoming calls (Fallback for when WebSockets are not set up)
     */
    public function checkIncomingCall(Request $request)
    {
        $user = Auth::guard('patient')->user();
        if (!$user) return response()->json(['incoming' => false]);

        // Find the most recent 'ringing' call for this patient created in the last 2 minutes
        $call = VideoConsultation::where('patient_id', $user->id)
            ->where('status', 'ringing')
            ->where('created_at', '>=', now()->subMinutes(2))
            ->with('doctor')
            ->latest()
            ->first();

        if ($call) {
            return response()->json([
                'incoming' => true,
                'call_id' => $call->id,
                'doctor_name' => $call->doctor->name,
                'room_url' => json_decode($call->meta_data)->url ?? '',
                'room_name' => $call->room_name
            ]);
        }

        return response()->json(['incoming' => false]);
    }
}
