<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens';

    protected $fillable = [
        'email',
        'token',
        'new_password',
        'created_at',
    ];

    public $timestamps = false;

    protected $dates = ['created_at'];
}
