<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialization',
        'qualification',
        'experience_years',
        'phone',
        'email',
        'bio',
        'profile_image',
        'status',
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function getFullInfoAttribute()
    {
        return "Dr. {$this->name} - {$this->specialization} ({$this->qualification})";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
