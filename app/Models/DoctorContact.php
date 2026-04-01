<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'title',
        'type',
        'content',
    ];
}

class DoctorContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'name',
        'email',
        'subject',
        'message',
        'status',
    ];
}
