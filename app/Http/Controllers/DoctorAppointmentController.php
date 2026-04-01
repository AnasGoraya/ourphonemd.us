<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;

class DoctorAppointmentController extends Controller
{
    public function patientSearch(Request $request)
    {
        $q = $request->input('q');
        if (!$q) {
            return response()->json(['data' => []]);
        }

        $patients = \App\Models\Patient::where(function($query) use ($q) {
            $query->where('first_name', 'like', "%{$q}%")
                  ->orWhere('last_name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%");
        })->limit(20)->get(['id','first_name','last_name','email']);

        $results = $patients->map(function($p) {
            return [
                'id' => $p->id,
                'name' => trim($p->first_name . ' ' . $p->last_name),
                'email' => $p->email
            ];
        });

        return response()->json(['data' => $results]);
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|integer',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string',
        ]);

        $exists = \App\Models\Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        return response()->json(['available' => !$exists]);
    }

    public function pay(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string',
            'cardName' => 'required|string',
            'cardNumber' => 'required|string',
            'cardExpMonth' => 'required|string',
            'cardExpYear' => 'required|string',
            'cardCVC' => 'required|string',
        ]);

        try {
            $doctor = Auth::user();
            if (!$doctor || $doctor->id != $request->doctor_id) {
                return response()->json(['error' => 'Unauthorized doctor'], 403);
            }

            Stripe::setApiKey(config('services.stripe.secret') ?? env('STRIPE_SECRET'));

            // For server-side test flow use tok_visa
            $token = 'tok_visa';

            $charge = Charge::create([
                'amount' => 10000,
                'currency' => 'usd',
                'description' => 'Appointment payment by doctor',
                'source' => $token,
            ]);

            DB::beginTransaction();
            // Create payment record
            $payment = \App\Models\Payment::create([
                'patient_id' => $request->patient_id,
                'stripe_charge_id' => $charge->id,
                'stripe_token' => $token,
                'amount' => 100.00,
                'currency' => 'usd',
                'status' => $charge->status,
                'description' => 'Appointment payment (doctor-side)',
                'card_details' => [
                    'name' => $request->cardName,
                    'number_last4' => substr($request->cardNumber, -4),
                    'exp_month' => $request->cardExpMonth,
                    'exp_year' => $request->cardExpYear,
                ],
                'stripe_response' => $charge->toArray(),
                'processed_at' => now(),
            ]);

            $appointmentData = [
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'status' => 'scheduled',
                'appointment_mode' => $request->appointment_mode ?? 'in-person',
                'token' => \Illuminate\Support\Str::random(24),
            ];

            $appointment = \App\Models\Appointment::create($appointmentData);

            $payment->update(['appointment_id' => $appointment->id]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Payment successful', 'appointment_id' => $appointment->id]);

        } catch (ApiErrorException $e) {
            Log::error('Stripe error: ' . $e->getMessage());
            return response()->json(['error' => 'Payment failed: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment/create error: ' . $e->getMessage());
            return response()->json(['error' => 'Payment or save failed'], 500);
        }
    }
}
