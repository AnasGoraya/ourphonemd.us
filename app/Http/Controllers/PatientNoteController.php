<?php

namespace App\Http\Controllers;

use App\Models\PatientNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PatientNoteController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Storing patient note attempt', $request->all());

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'type' => 'required|in:medical,school,work,general',
            'content' => 'required|string',
            'appointment_id' => 'nullable|exists:appointments,id',
        ]);

        try {
            $data = $request->only(['patient_id', 'type', 'content', 'appointment_id']);
            $data['doctor_id'] = Auth::id();

            if ($request->hasFile('attachment')) {
                 $request->validate(['attachment' => 'file|max:10240']);
                 $data['attachment_path'] = $request->file('attachment')->store('patient_notes', 'public');
            }

            $note = PatientNote::create($data);

            return response()->json([
                'success' => true, 
                'message' => 'Note saved successfully.',
                'note' => $note
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving note: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to save note: ' . $e->getMessage()], 500);
        }
    }
    public function resend($id)
    {
        try {
            $note = PatientNote::findOrFail($id);
            
            // Mark as visible to patient
            $note->is_visible_to_patient = true;
            $note->sent_at = now();
            $note->save();

            Log::info("Sent/Resent note ID {$id} to patient ID {$note->patient_id}");

            // Ideally trigger email here
            // Mail::to($note->patient->email)->send(new PatientNoteMail($note));

            // Trigger internal notification
            $note->patient->notify(new \App\Notifications\NewDoctorNote($note));

            return response()->json(['success' => true, 'message' => 'Note sent to patient successfully.']);
        } catch (\Exception $e) {
            Log::error("Error sending note: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send note.'], 500);
        }
    }
}
