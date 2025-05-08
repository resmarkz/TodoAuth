<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'due_date',
        'completed',
    ];

    public function isOverdue()
    {
        return $this->due_date && now()->gt($this->due_date);
    }

    public function isDueSoon()
    {
        return $this->due_date && 
            now()->lt($this->due_date) && 
            now()->diffInDays($this->due_date) <= 3;
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
