<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FamilyMember extends Model
{
    use HasFactory;

    protected $table = 'family_members';

    protected $fillable = [
        'patient_id',
        'first_name',
        'middle_name',
        'last_name',
        'relationship',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'state',
        'zip_code',
        'email',
        'phone',
        'profile_picture',
        'use_parent_insurance',
        'add_insurance',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'use_parent_insurance' => 'boolean',
        'add_insurance' => 'boolean',
    ];

    /**
     * Get the patient that owns the family member.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * Get the full name of the family member.
     */
    public function getFullNameAttribute()
    {
        $name = $this->first_name;
        if ($this->middle_name) {
            $name .= ' ' . $this->middle_name;
        }
        $name .= ' ' . $this->last_name;
        return $name;
    }

    /**
     * Get the profile picture URL.
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
        return null;
    }

    /**
     * Delete the family member and cleanup files.
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($familyMember) {
            if ($familyMember->profile_picture) {
                Storage::disk('public')->delete($familyMember->profile_picture);
            }
        });
    }
}
