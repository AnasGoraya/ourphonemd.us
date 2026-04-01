<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'family_member_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'appointment_type',
        'appointment_mode',
        'reason',
        'symptoms',
        'medications',
        'allergies',
        'work_notes',
        'alt_phone',
        'images',
        'medical_history',
        'notes',
        'priority',
        'status',
        'sent_to_doctor',
        'wizard_step1_data',
        'wizard_step2_data',
        'wizard_step3_data',
        'token',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class, 'family_member_id');
    }

    public function doctor()
    {
        // If your doctors are stored in the User model, keep User::class. If in Doctor model, change to Doctor::class.
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function patientNotes()
    {
        return $this->hasMany(PatientNote::class);
    }

    // Accessor for patient name (for display purposes)
    public function getPatientDisplayNameAttribute()
    {
        // If family member appointment
        if ($this->family_member_id && $this->familyMember) {
            return $this->familyMember->first_name . ' ' . $this->familyMember->last_name . ' (' . $this->familyMember->relationship . ')';
        }

        // If wizard data exists
        if ($this->wizard_step2_data) {
            $step2Data = json_decode($this->wizard_step2_data, true);
            if (isset($step2Data['patient_selection']) && str_starts_with($step2Data['patient_selection'], 'family_')) {
                $familyMemberId = str_replace('family_', '', $step2Data['patient_selection']);
                $familyMember = FamilyMember::find($familyMemberId);
                if ($familyMember) {
                    return $familyMember->first_name . ' ' . $familyMember->last_name . ' (' . $familyMember->relationship . ')';
                }
            }
        }

        // Default to main patient
        if ($this->patient) {
            return $this->patient->first_name . ' ' . $this->patient->last_name . ' (Self)';
        }

        return 'Unknown Patient';
    }

    // Accessor for patient type
    public function getPatientTypeAttribute()
    {
        if ($this->family_member_id) {
            return 'family';
        }

        if ($this->wizard_step2_data) {
            $step2Data = json_decode($this->wizard_step2_data, true);
            if (isset($step2Data['patient_selection']) && str_starts_with($step2Data['patient_selection'], 'family_')) {
                return 'family';
            }
        }

        return 'self';
    }

    // Accessor for getting the actual patient object (main patient or family member)
    public function getAppointmentForAttribute()
    {
        if ($this->family_member_id) {
            $familyMember = $this->familyMember;
            if ($familyMember) {
                return [
                    'type' => 'family',
                    'id' => $familyMember->id,
                    'first_name' => $familyMember->first_name,
                    'last_name' => $familyMember->last_name,
                    'relationship' => $familyMember->relationship
                ];
            } else {
                // Family member not found, but ID exists - show ID for linking
                return [
                    'type' => 'family',
                    'id' => $this->family_member_id,
                    'first_name' => 'Family Member',
                    'last_name' => '(ID: ' . $this->family_member_id . ')',
                    'relationship' => 'Not Found'
                ];
            }
        }

        if ($this->wizard_step2_data) {
            $step2Data = json_decode($this->wizard_step2_data, true);
            if (isset($step2Data['patient_selection']) && str_starts_with($step2Data['patient_selection'], 'family_')) {
                $familyMemberId = str_replace('family_', '', $step2Data['patient_selection']);
                $familyMember = FamilyMember::find($familyMemberId);
                if ($familyMember) {
                    return [
                        'type' => 'family',
                        'id' => $familyMember->id,
                        'first_name' => $familyMember->first_name,
                        'last_name' => $familyMember->last_name,
                        'relationship' => $familyMember->relationship
                    ];
                } else {
                    // Family member not found, but ID exists - show ID for linking
                    return [
                        'type' => 'family',
                        'id' => $familyMemberId,
                        'first_name' => 'Family Member',
                        'last_name' => '(ID: ' . $familyMemberId . ')',
                        'relationship' => 'Not Found'
                    ];
                }
            }
        }

        // Default to main patient
        if ($this->patient) {
            return [
                'type' => 'self',
                'id' => $this->patient->id,
                'first_name' => $this->patient->first_name,
                'last_name' => $this->patient->last_name,
                'relationship' => 'Self'
            ];
        }

        return null;
    }
}
