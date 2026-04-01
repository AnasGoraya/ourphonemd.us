<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Stripe\Charge;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Exception\ApiErrorException;

class PatientPaymentController extends Controller
{
    /**
     * Process a payment using Stripe token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pay(Request $request)
    {
        Log::info('=== PAY METHOD CALLED ===');
        Log::info('Request data: ' . json_encode($request->all()));

        $request->validate([
            'cardName' => 'required|string',
            'cardNumber' => 'required|string',
            'cardExpMonth' => 'required|string',
            'cardExpYear' => 'required|string',
            'cardCVC' => 'required|string',
        ]);

        Stripe::setApiKey(config('services.stripe.secret') ?? 'sk_test_4eC39HqLyjWDarhtT657tct8');

        try {
            // Get patient before creating payment record
            Log::info('Checking if patient is authenticated...');
            $patient = Auth::guard('patient')->user();
            if (!$patient) {
                Log::error('❌ No patient logged in during payment');
                return redirect()->route('patient.signin')->withErrors(['error' => 'You must be logged in to make a payment.']);
            }

            Log::info('✅ Patient authenticated: ID ' . $patient->id . ' (' . $patient->first_name . ' ' . $patient->last_name . ')');

            // Get wizard data from session BEFORE creating payment
            $wizardData = session('appointment_wizard');
            Log::info('Wizard Data from session: ' . json_encode($wizardData));

            if (!$wizardData || !isset($wizardData['step3'])) {
                Log::error('❌ Session expired or step3 data missing. Wizard Data: ' . json_encode($wizardData));
                return redirect()->route('patient.appointments.wizard.step1')->withErrors(['error' => 'Session expired. Please start over.']);
            }

            // Validate required wizard data
            if (!isset($wizardData['step3']['doctor_id']) || !isset($wizardData['step3']['appointment_date']) || !isset($wizardData['step3']['appointment_time'])) {
                Log::error('❌ Required wizard step3 data missing: ' . json_encode($wizardData['step3'] ?? []));
                return redirect()->route('patient.appointments.wizard.step1')->withErrors(['error' => 'Session data incomplete. Please start over.']);
            }

            // Check if doctor already has an appointment at same time
            $existingAppointment = \App\Models\Appointment::where('doctor_id', $wizardData['step3']['doctor_id'])
                ->where('appointment_date', $wizardData['step3']['appointment_date'])
                ->where('appointment_time', $wizardData['step3']['appointment_time'])
                ->whereNotIn('status', ['cancelled'])
                ->first();

            if ($existingAppointment) {
                Log::warning('❌ Time slot already booked for doctor at this time');
                return redirect()->route('patient.appointments.wizard.step4')->withErrors(['error' => 'This time slot is already booked for the selected doctor. Please choose a different time.']);
            }

            // For testing, use Stripe test token instead of raw card data
            // Use test token: tok_visa (successful) or tok_chargeDeclined (declined)
            $testToken = 'tok_visa'; // This will always succeed in test mode

            // Log the token being sent to Stripe for debugging
            Log::info('=== STRIPE PAYMENT PROCESSING ===');
            Log::info('Stripe Payment Token: ' . $testToken);
            Log::info('Card Details Submitted: Name=' . $request->cardName . ', Number=****' . substr($request->cardNumber, -4) . ', Exp=' . $request->cardExpMonth . '/' . $request->cardExpYear);
            Log::info('Sending token to Stripe API...');
            Log::info('API Key Set: ' . (strlen(config('services.stripe.secret')) > 10 ? 'YES' : 'NO'));

            set_time_limit(60); // Increase time limit for Stripe API call

            Log::info('Creating Stripe charge with test token...');
            Log::info('Stripe API Key configured: ' . (config('services.stripe.secret') ? 'YES' : 'NO'));

            // Create Stripe charge
            $charge = Charge::create([
                'amount' => 10000, // $100 in cents
                'currency' => 'usd',
                'description' => 'Appointment payment',
                'source' => $testToken,
            ]);

            Log::info('✅ Stripe charge created successfully!');
            Log::info('Stripe API Response - Charge ID: ' . $charge->id . ', Status: ' . $charge->status);
            Log::info('✅ PAYMENT SUCCESSFUL: Token tok_visa was sent to Stripe and processed successfully!');
            Log::info('✅ APPOINTMENT WILL BE CREATED NOW');

            // Use database transaction to ensure atomicity
            DB::beginTransaction();
            try {
                // Store payment record in database
                $payment = \App\Models\Payment::create([
                    'patient_id' => $patient->id,
                    'stripe_charge_id' => $charge->id,
                    'stripe_token' => $testToken,
                    'amount' => 100.00, // $100
                    'currency' => 'usd',
                    'status' => $charge->status,
                    'description' => 'Appointment payment',
                    'card_details' => [
                        'name' => $request->cardName,
                        'number_last4' => substr($request->cardNumber, -4),
                        'exp_month' => $request->cardExpMonth,
                        'exp_year' => $request->cardExpYear,
                    ],
                    'stripe_response' => $charge->toArray(),
                    'processed_at' => now(),
                ]);

                Log::info('✅ Payment record saved to database: ID ' . $payment->id);

                // Prepare appointment data
                $appointmentData = [
                    'patient_id' => $patient->id,
                    'doctor_id' => $wizardData['step3']['doctor_id'],
                    'appointment_date' => $wizardData['step3']['appointment_date'],
                    'appointment_time' => $wizardData['step3']['appointment_time'],
                    'symptoms' => $wizardData['step3']['symptoms'] ?? null,
                    'priority' => (isset($wizardData['step1']['is_adhd_appointment']) && $wizardData['step1']['is_adhd_appointment']) ? 'urgent' : 'normal',
                    'status' => 'in_progress', // Initially in progress until receptionist confirms
                    'appointment_mode' => $wizardData['step3']['appointment_mode'] ?? 'in-person',
                    'wizard_step1_data' => json_encode($wizardData['step1'] ?? []),
                    'wizard_step2_data' => json_encode($wizardData['step2'] ?? []),
                    'wizard_step3_data' => json_encode($wizardData['step3'] ?? []),
                ];

                // If it's a family member appointment, store the family_member_id
                if (isset($wizardData['step2']['patient_selection']) && str_starts_with($wizardData['step2']['patient_selection'], 'family_')) {
                    $familyMemberId = str_replace('family_', '', $wizardData['step2']['patient_selection']);
                    $appointmentData['family_member_id'] = $familyMemberId;
                    Log::info('Family member appointment: family_member_id = ' . $familyMemberId);
                }

                $appointmentData['token'] = \Illuminate\Support\Str::random(24);
                Log::info('Appointment Data before creation: ' . json_encode($appointmentData));

                $appointment = \App\Models\Appointment::create($appointmentData);
                Log::info('✅ Appointment created: ID ' . $appointment->id);

                // Update payment with appointment_id
                $payment->update(['appointment_id' => $appointment->id]);
                Log::info('✅ Payment linked to appointment: Payment ID ' . $payment->id . ', Appointment ID ' . $appointment->id);

                // Commit the transaction
                DB::commit();
                Log::info('✅ Database transaction committed successfully');

                // Clear the wizard session
                session()->forget('appointment_wizard');
                Log::info('Wizard session cleared');

                // Put success message persistently into session (will be cleared manually in dashboard)
                session()->put('success_message', 'Your appointment has been booked successfully!');
                
                Log::info('=== PAYMENT FLOW COMPLETE - Session message set ===');
                return redirect()->route('patient.appointment.dashboard');

            } catch (\Exception $e) {
                // Rollback the transaction on any error
                DB::rollBack();
                Log::error('❌ Database transaction failed, rolled back: ' . $e->getMessage());
                Log::error('Error trace: ' . $e->getTraceAsString());
                return redirect()->route('patient.appointments.wizard.step4')->withErrors(['error' => 'Failed to save appointment. Please try again.']);
            }

        } catch (ApiErrorException $e) {
            Log::error('Stripe API Error: ' . $e->getMessage());
            Log::error('Stripe API Error Type: ' . get_class($e));
            Log::error('Stripe API Error Code: ' . $e->getStripeCode());
            Log::error('Stripe Error Trace: ' . $e->getTraceAsString());
            // Pass Stripe error to the view
            return redirect()->route('patient.appointments.wizard.step4')->withErrors(['payment' => 'Payment failed: ' . $e->getMessage()]);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::error('Network Connection Error to Stripe: ' . $e->getMessage());
            Log::error('Network Error Trace: ' . $e->getTraceAsString());
            return redirect()->route('patient.appointments.wizard.step4')->withErrors(['payment' => 'Network error. Please check your connection and try again.']);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error('Request Exception: ' . $e->getMessage());
            Log::error('Request Error Trace: ' . $e->getTraceAsString());
            return redirect()->route('patient.appointments.wizard.step4')->withErrors(['payment' => 'Request failed. Please try again.']);
        } catch (\Exception $e) {
            Log::error('Payment Error: ' . $e->getMessage());
            Log::error('Error Type: ' . get_class($e));
            Log::error('Error Code: ' . $e->getCode());
            Log::error('Trace: ' . $e->getTraceAsString());
            // Pass any other error to the view
            return redirect()->route('patient.appointments.wizard.step4')->withErrors(['payment' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}
