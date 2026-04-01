<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'insurance_type',
        'policy_number',
        'member_name',
        'group_number',
        'insurance_provider',
        'edi_payer',
        'insurance_id',
        'coverage_type',
        'effective_date',
        'expiration_date',
        'relationship',
        'is_primary',
        'card_front_image',
        'card_back_image',
        'subscriber_name',
        'subscriber_copay',
        'subscriber_ssn',
        'subscriber_date_of_birth',
        'subscriber_address',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'expiration_date' => 'date',
        'subscriber_date_of_birth' => 'date',
        'is_primary' => 'boolean',
    ];

    /**
     * Get the patient that owns the insurance.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the family member that owns the insurance (nullable).
     */
    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class, 'family_member_id');
    }

    /**
     * Get front card image URL
     */
    public function getCardFrontImageUrlAttribute()
    {
        if ($this->card_front_image) {
            return asset('storage/' . $this->card_front_image);
        }
        return null;
    }

    /**
     * Get back card image URL
     */
    public function getCardBackImageUrlAttribute()
    {
        if ($this->card_back_image) {
            return asset('storage/' . $this->card_back_image);
        }
        return null;
    }
}
