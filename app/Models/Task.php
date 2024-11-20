<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',

        'user_id',
        'assignee_id',
    ];
    // Task status options
    const STATUS_OPEN = 'open';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_COMPLETED = 'completed';

    // Define the valid statuses
    public static function getStatuses()
    {
        return [
            self::STATUS_OPEN,
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETED,
        ];
    }
    /**
     * Get the user who created the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user to whom the task is assigned.
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * Get comments related to the task.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
