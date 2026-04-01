<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InsuranceController extends Controller
{
    /**
     * Store a newly created insurance in storage.
     */
    // public function store(Request $request)
    // {

    // try {
    //     $validated = $request->validate([
    //         'insurance_type' => 'required|string',
    //         'policy_number' => 'required|string',
    //         'member_name' => 'required|string',
    //         'group_number' => 'nullable|string',
    //         'insurance_provider' => 'required|string',
    //         'edi_payer' => 'nullable|string',
    //         'insurance_id' => 'required|string',
    //         'coverage_type' => 'nullable|string',
    //         'effective_date' => 'nullable|date',
    //         'expiration_date' => 'nullable|date',
    //         'relationship' => 'required|string',
    //         'is_primary' => 'nullable|boolean',
    //         'card_front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    //         'card_back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    //         'subscriber_name' => 'nullable|string',
    //         'subscriber_copay' => 'nullable|string',
    //         'subscriber_ssn' => 'nullable|string',
    //         'subscriber_date_of_birth' => 'nullable|date',
    //         'subscriber_address' => 'nullable|string',
    //     ]);
    //         // Get the authenticated patient
    //         $patient = auth('patient')->user();

    //         if (!$patient) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Unauthorized access'
    //             ], 401);
    //         }

    //         // If this is set as primary, remove primary from other insurances
    //         if ($request->is_primary) {
    //             Insurance::where('patient_id', $patient->id)->update(['is_primary' => false]);
    //         }

    //         // Handle file uploads
    //         $cardFrontPath = null;
    //         $cardBackPath = null;

    //         if ($request->hasFile('card_front_image')) {
    //             $cardFrontPath = $request->file('card_front_image')->store('insurances/front', 'public');
    //         }

    //         if ($request->hasFile('card_back_image')) {
    //             $cardBackPath = $request->file('card_back_image')->store('insurances/back', 'public');
    //         }

    //         // Create the insurance record
    //         $insurance = Insurance::create([
    //             'patient_id' => $patient->id,
    //             'insurance_type' => $validated['insurance_type'],
    //             'policy_number' => $validated['policy_number'],
    //             'member_name' => $validated['member_name'],
    //             'group_number' => $validated['group_number'],
    //             'insurance_provider' => $validated['insurance_provider'],
    //             'edi_payer' => $validated['edi_payer'],
    //             'insurance_id' => $validated['insurance_id'],
    //             'coverage_type' => $validated['coverage_type'],
    //             'effective_date' => $validated['effective_date'],
    //             'expiration_date' => $validated['expiration_date'],
    //             'relationship' => $validated['relationship'],
    //             'is_primary' => $validated['is_primary'] ?? false,
    //             'card_front_image' => $cardFrontPath,
    //             'card_back_image' => $cardBackPath,
    //             'subscriber_name' => $validated['subscriber_name'],
    //             'subscriber_copay' => $validated['subscriber_copay'],
    //             'subscriber_ssn' => $validated['subscriber_ssn'],
    //             'subscriber_date_of_birth' => $validated['subscriber_date_of_birth'],
    //             'subscriber_address' => $validated['subscriber_address'],
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Insurance added successfully',
    //             'insurance' => $insurance
    //         ], 201);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validation error',
    //             'errors' => $e->errors()
    //         ], 422);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error saving insurance: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'insurance_type' => 'required|string',
            'policy_number' => 'required|string',
            'member_name' => 'required|string',
            'insurance_provider' => 'required|string',
            'insurance_id' => 'required|string',
            'relationship' => 'required|string',
            'group_number' => 'nullable|string',
            'edi_payer' => 'nullable|string',
            'coverage_type' => 'nullable|string',
            'effective_date' => 'nullable|date',
            'expiration_date' => 'nullable|date',
            'is_primary' => 'nullable|boolean',
            'card_front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'card_back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'subscriber_name' => 'nullable|string',
            'subscriber_copay' => 'nullable|string',
            'subscriber_ssn' => 'nullable|string',
            'subscriber_date_of_birth' => 'nullable|date',
            'subscriber_address' => 'nullable|string',
        ]);

        // باقی store method کا code
        $patient = auth('patient')->user();

        if ($request->boolean('is_primary')) {
            \App\Models\Insurance::where('patient_id', $patient->id)->update(['is_primary' => false]);
        }

        $cardFrontPath = $request->hasFile('card_front_image')
            ? $request->file('card_front_image')->store('insurances/front', 'public')
            : null;

        $cardBackPath = $request->hasFile('card_back_image')
            ? $request->file('card_back_image')->store('insurances/back', 'public')
            : null;

        // Handle member_name - if it's a number, it's a family member ID
        $familyMemberId = null;
        $memberName = $validated['member_name'];

        if (is_numeric($memberName)) {
            $familyMemberId = $memberName;
            // Get the family member to set member_name to their full name
            $familyMember = \App\Models\FamilyMember::where('id', $familyMemberId)
                ->where('patient_id', $patient->id)
                ->first();
            if ($familyMember) {
                $memberName = $familyMember->full_name;
            }
        }

        $insurance = \App\Models\Insurance::create([
            'patient_id' => $patient->id,
            'family_member_id' => $familyMemberId,
            // تمام fields include کریں
            'insurance_type' => $validated['insurance_type'],
            'policy_number' => $validated['policy_number'],
            'member_name' => $memberName,
            'group_number' => $validated['group_number'],
            'insurance_provider' => $validated['insurance_provider'],
            'edi_payer' => $validated['edi_payer'],
            'insurance_id' => $validated['insurance_id'],
            'coverage_type' => $validated['coverage_type'],
            'effective_date' => $validated['effective_date'],
            'expiration_date' => $validated['expiration_date'],
            'relationship' => $validated['relationship'],
            'is_primary' => $request->boolean('is_primary'),
            'card_front_image' => $cardFrontPath,
            'card_back_image' => $cardBackPath,
            'subscriber_name' => $validated['subscriber_name'],
            'subscriber_copay' => $validated['subscriber_copay'],
            'subscriber_ssn' => $validated['subscriber_ssn'],
            'subscriber_date_of_birth' => $validated['subscriber_date_of_birth'],
            'subscriber_address' => $validated['subscriber_address'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Insurance added successfully',
            'insurance' => $insurance
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Please fix the validation errors',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error saving insurance: ' . $e->getMessage()
        ], 500);
    }
}
    /**
     * Get all insurances for the authenticated patient.
     */
    public function getInsurances()
    {
        try {
            $patient = auth('patient')->user();

            if (!$patient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 401);
            }

            $insurances = Insurance::where('patient_id', $patient->id)
                ->orderBy('is_primary', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($insurance) {
                    return [
                        'id' => $insurance->id,
                        'insurance_type' => $insurance->insurance_type,
                        'policy_number' => $insurance->policy_number,
                        'member_name' => $insurance->member_name,
                        'group_number' => $insurance->group_number,
                        'insurance_provider' => $insurance->insurance_provider,
                        'edi_payer' => $insurance->edi_payer,
                        'insurance_id' => $insurance->insurance_id,
                        'coverage_type' => $insurance->coverage_type,
                        'effective_date' => $insurance->effective_date,
                        'expiration_date' => $insurance->expiration_date,
                        'relationship' => $insurance->relationship,
                        'is_primary' => $insurance->is_primary,
                        'card_front_image_url' => $insurance->card_front_image_url,
                        'card_back_image_url' => $insurance->card_back_image_url,
                        'subscriber_name' => $insurance->subscriber_name,
                        'subscriber_copay' => $insurance->subscriber_copay,
                        'subscriber_ssn' => $insurance->subscriber_ssn,
                        'subscriber_date_of_birth' => $insurance->subscriber_date_of_birth,
                        'subscriber_address' => $insurance->subscriber_address,
                        'created_at' => $insurance->created_at,
                    ];
                });

            return response()->json([
                'success' => true,
                'insurances' => $insurances
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching insurances: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified insurance.
     */
  public function update(Request $request, $id)
{
    try {
        $patient = auth('patient')->user();

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 401);
        }

        $insurance = Insurance::where('id', $id)
            ->where('patient_id', $patient->id)
            ->firstOrFail();

        $validated = $request->validate([
            'insurance_type' => 'required|string',
            'policy_number' => 'required|string',
            'member_name' => 'required|string',
            // 'group_number' => 'nullable|string',
            'insurance_provider' => 'required|string',
            'edi_payer' => 'nullable|string',
            'insurance_id' => 'required|string',
            'coverage_type' => 'nullable|string',
            'effective_date' => 'nullable|date',
            'expiration_date' => 'nullable|date',
            'relationship' => 'required|string',
            'is_primary' => 'nullable|boolean',
            'card_front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'card_back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'subscriber_name' => 'nullable|string',
            'subscriber_copay' => 'nullable|string',
            'subscriber_ssn' => 'nullable|string',
            'subscriber_date_of_birth' => 'nullable|date',
            'subscriber_address' => 'nullable|string',
        ]);

        if ($request->is_primary) {
            Insurance::where('patient_id', $patient->id)
                ->where('id', '!=', $id)
                ->update(['is_primary' => false]);
        }

        // Handle file uploads
        if ($request->hasFile('card_front_image')) {
            if ($insurance->card_front_image) {
                Storage::disk('public')->delete($insurance->card_front_image);
            }
            $validated['card_front_image'] = $request->file('card_front_image')->store('insurances/front', 'public');
        }

        if ($request->hasFile('card_back_image')) {
            if ($insurance->card_back_image) {
                Storage::disk('public')->delete($insurance->card_back_image);
            }
            $validated['card_back_image'] = $request->file('card_back_image')->store('insurances/back', 'public');
        }

        $insurance->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Insurance updated successfully',
            'insurance' => $insurance
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error updating insurance: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Delete the specified insurance.
     */
    public function destroy($id)
    {
        try {
            $patient = auth('patient')->user();

            if (!$patient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 401);
            }

            $insurance = Insurance::where('id', $id)
                ->where('patient_id', $patient->id)
                ->firstOrFail();

            // Delete card images
            if ($insurance->card_front_image) {
                Storage::disk('public')->delete($insurance->card_front_image);
            }
            if ($insurance->card_back_image) {
                Storage::disk('public')->delete($insurance->card_back_image);
            }

            $insurance->delete();

            return response()->json([
                'success' => true,
                'message' => 'Insurance deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting insurance: ' . $e->getMessage()
            ], 500);
        }
    }
}
