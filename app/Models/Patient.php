<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    use HasFactory, Notifiable;

  protected $fillable = [
    'first_name',
    'middle_name',
    'last_name',
    'email',
    'password',
    'gender',
    'date_of_birth',
    'age',
    'cnic',
    'contact_number',
    'secondary_contact',
    'emergency_contact',
    'address',
    'city',
    'state',
    'zip_code',
    'profile_picture',
    'guardian_name',
    'blood_group',
    'marital_status',
    'medical_history',
    'verification_token', // ✅ Ensure this exists
    'email_verified_at',  // ✅ Ensure this exists
    'status',
];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function insurances()
    {
        return $this->hasMany(Insurance::class);
    }

    /**
     * Get patient's full name
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get patient's age from date of birth
     */
    public function getCalculatedAgeAttribute()
    {
        if ($this->date_of_birth) {
            return now()->diffInYears($this->date_of_birth);
        }
        return $this->age;
    }

    /**
     * Get profile picture URL
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
    }
}
