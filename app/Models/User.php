<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
  protected $fillable = [
    'name',
    'email',
    'password',
    'role_id',
    'verification_token',
    'email_verified_at',
    'email_status',
    'status',
];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected function casts(): array
    // {
    //      return[
    //         'password' => 'hashed',
    //      ];
    // }
    public function comments()
{
    return $this->hasMany(Comment::class);
}
/**
 * Send the password reset notification.
 */


}
