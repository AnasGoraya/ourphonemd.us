<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'task_id',
        'user_id',
    ];

    // Relation with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation with Task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
