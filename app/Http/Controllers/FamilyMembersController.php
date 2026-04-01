<?php

namespace App\Http\Controllers;

use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FamilyMembersController extends Controller
{
    /**
     * Store a newly created family member in storage.
     */
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'first_name' => 'required|string|max:255',
    //         'middle_name' => 'nullable|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'relationship' => 'required|in:spouse,child,parent,sibling,other',
    //         'date_of_birth' => 'required|date',
    //         'gender' => 'required|in:male,female,other',
    //         'address' => 'required|string|max:255',
    //         'city' => 'required|string|max:255',
    //         'state' => 'required|string|max:255',
    //         'zip_code' => 'required|string|max:20',
    //         'email' => 'required|email|max:255',
    //         'phone' => 'required|string|max:20',
    //         'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'use_parent_insurance' => 'nullable|boolean',
    //         'add_insurance' => 'nullable|boolean',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validation failed',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     try {
    //         $patientId = auth('patient')->id();

    //         $familyMemberData = $validator->validated();
    //         $familyMemberData['patient_id'] = $patientId;

    //         // Handle profile picture upload
    //         if ($request->hasFile('profile_picture')) {
    //             $file = $request->file('profile_picture');
    //             $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    //             $path = $file->storeAs("family-members/{$patientId}", $fileName, 'public');
    //             $familyMemberData['profile_picture'] = $path;
    //         }

    //         $familyMember = FamilyMember::create($familyMemberData);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Family member added successfully',
    //             'data' => [
    //                 'id' => $familyMember->id,
    //                 'full_name' => $familyMember->full_name,
    //                 'first_name' => $familyMember->first_name,
    //                 'middle_name' => $familyMember->middle_name,
    //                 'last_name' => $familyMember->last_name,
    //                 'relationship' => $familyMember->relationship,
    //                 'date_of_birth' => $familyMember->date_of_birth,
    //                 'gender' => $familyMember->gender,
    //                 'address' => $familyMember->address,
    //                 'city' => $familyMember->city,
    //                 'state' => $familyMember->state,
    //                 'zip_code' => $familyMember->zip_code,
    //                 'email' => $familyMember->email,
    //                 'phone' => $familyMember->phone,
    //                 'profile_picture_url' => $familyMember->profile_picture_url,
    //                 'use_parent_insurance' => $familyMember->use_parent_insurance,
    //                 'add_insurance' => $familyMember->add_insurance,
    //                 'created_at' => $familyMember->created_at->format('M d, Y')
    //             ]
    //         ], 201);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error adding family member: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function store(Request $request)
    {
        // Convert checkbox values to boolean
        $request->merge([
            'use_parent_insurance' => $request->has('use_parent_insurance'),
            'add_insurance' => $request->has('add_insurance'),
        ]);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'relationship' => 'required|in:spouse,child,parent,sibling,other',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'use_parent_insurance' => 'nullable|boolean',
            'add_insurance' => 'nullable|boolean',
        ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        // TEMPORARY: Use a default patient ID for testing
        $patientId = auth('patient')->id() ?? 1; // Use 1 as default for testing

        if (!$patientId) {
            return response()->json([
                'success' => false,
                'message' => 'Patient authentication required'
            ], 401);
        }

        $familyMemberData = $validator->validated();
        $familyMemberData['patient_id'] = $patientId;

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs("family-members/{$patientId}", $fileName, 'public');
            $familyMemberData['profile_picture'] = $path;
        }

        $familyMember = FamilyMember::create($familyMemberData);

        return response()->json([
            'success' => true,
            'message' => 'Family member added successfully',
            'data' => [
                'id' => $familyMember->id,
                'full_name' => $familyMember->full_name,
                'first_name' => $familyMember->first_name,
                'middle_name' => $familyMember->middle_name,
                'last_name' => $familyMember->last_name,
                'relationship' => $familyMember->relationship,
                'date_of_birth' => $familyMember->date_of_birth,
                'gender' => $familyMember->gender,
                'address' => $familyMember->address,
                'city' => $familyMember->city,
                'state' => $familyMember->state,
                'zip_code' => $familyMember->zip_code,
                'email' => $familyMember->email,
                'phone' => $familyMember->phone,
                'profile_picture_url' => $familyMember->profile_picture_url,
                'use_parent_insurance' => $familyMember->use_parent_insurance,
                'add_insurance' => $familyMember->add_insurance,
                'created_at' => $familyMember->created_at->format('M d, Y')
            ]
        ], 201);
    } catch (\Exception $e) {
        Log::error('Family Member Store Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error adding family member: ' . $e->getMessage()
        ], 500);
    }
}
    /**
     * Get all family members for the authenticated patient.
     */
    public function getFamilyMembers()
    {
        try {
            $patientId = auth('patient')->id();
            $familyMembers = FamilyMember::where('patient_id', $patientId)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($member) {
                    return [
                        'id' => $member->id,
                        'full_name' => $member->full_name,
                        'first_name' => $member->first_name,
                        'middle_name' => $member->middle_name,
                        'last_name' => $member->last_name,
                        'relationship' => $member->relationship,
                        'date_of_birth' => $member->date_of_birth,
                        'gender' => $member->gender,
                        'address' => $member->address,
                        'city' => $member->city,
                        'state' => $member->state,
                        'zip_code' => $member->zip_code,
                        'email' => $member->email,
                        'phone' => $member->phone,
                        'profile_picture_url' => $member->profile_picture_url,
                        'use_parent_insurance' => $member->use_parent_insurance,
                        'add_insurance' => $member->add_insurance,
                        'created_at' => $member->created_at->format('M d, Y')
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $familyMembers
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving family members: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific family member.
     */
    public function show($id)
    {
        try {
            $patientId = auth('patient')->id();
            $familyMember = FamilyMember::where('id', $id)
                ->where('patient_id', $patientId)
                ->first();

            if (!$familyMember) {
                return response()->json([
                    'success' => false,
                    'message' => 'Family member not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $familyMember->id,
                    'full_name' => $familyMember->full_name,
                    'first_name' => $familyMember->first_name,
                    'middle_name' => $familyMember->middle_name,
                    'last_name' => $familyMember->last_name,
                    'relationship' => $familyMember->relationship,
                    'date_of_birth' => $familyMember->date_of_birth,
                    'gender' => $familyMember->gender,
                    'address' => $familyMember->address,
                    'city' => $familyMember->city,
                    'state' => $familyMember->state,
                    'zip_code' => $familyMember->zip_code,
                    'email' => $familyMember->email,
                    'phone' => $familyMember->phone,
                    'profile_picture_url' => $familyMember->profile_picture_url,
                    'use_parent_insurance' => $familyMember->use_parent_insurance,
                    'add_insurance' => $familyMember->add_insurance,
                    'created_at' => $familyMember->created_at->format('M d, Y')
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving family member: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a family member in storage.
     */
    public function update(Request $request, $id)
    {
        $patientId = auth('patient')->id();
        $familyMember = FamilyMember::where('id', $id)
            ->where('patient_id', $patientId)
            ->first();

        if (!$familyMember) {
            return response()->json([
                'success' => false,
                'message' => 'Family member not found'
            ], 404);
        }

        // Convert checkbox values to boolean
        $request->merge([
            'use_parent_insurance' => $request->has('use_parent_insurance'),
            'add_insurance' => $request->has('add_insurance'),
        ]);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'relationship' => 'required|in:spouse,child,parent,sibling,other',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'use_parent_insurance' => 'nullable|boolean',
            'add_insurance' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $familyMemberData = $validator->validated();

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                // Delete old profile picture
                if ($familyMember->profile_picture) {
                    Storage::disk('public')->delete($familyMember->profile_picture);
                }

                $file = $request->file('profile_picture');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs("family-members/{$patientId}", $fileName, 'public');
                $familyMemberData['profile_picture'] = $path;
            }

            $familyMember->update($familyMemberData);

            return response()->json([
                'success' => true,
                'message' => 'Family member updated successfully',
                'data' => [
                    'id' => $familyMember->id,
                    'full_name' => $familyMember->full_name,
                    'first_name' => $familyMember->first_name,
                    'middle_name' => $familyMember->middle_name,
                    'last_name' => $familyMember->last_name,
                    'relationship' => $familyMember->relationship,
                    'date_of_birth' => $familyMember->date_of_birth,
                    'gender' => $familyMember->gender,
                    'address' => $familyMember->address,
                    'city' => $familyMember->city,
                    'state' => $familyMember->state,
                    'zip_code' => $familyMember->zip_code,
                    'email' => $familyMember->email,
                    'phone' => $familyMember->phone,
                    'profile_picture_url' => $familyMember->profile_picture_url,
                    'use_parent_insurance' => $familyMember->use_parent_insurance,
                    'add_insurance' => $familyMember->add_insurance,
                    'created_at' => $familyMember->created_at->format('M d, Y')
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating family member: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a family member from storage.
     */
    public function destroy($id)
    {
        $patientId = auth('patient')->id();
        $familyMember = FamilyMember::where('id', $id)
            ->where('patient_id', $patientId)
            ->first();

        if (!$familyMember) {
            return response()->json([
                'success' => false,
                'message' => 'Family member not found'
            ], 404);
        }

        try {
            $familyMember->delete();

            return response()->json([
                'success' => true,
                'message' => 'Family member deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting family member: ' . $e->getMessage()
            ], 500);
        }
    }
}
