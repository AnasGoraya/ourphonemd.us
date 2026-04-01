<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'status',
        'assigned_by'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(Admin::class, 'assigned_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
