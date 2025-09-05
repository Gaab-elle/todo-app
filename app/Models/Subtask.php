<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subtask extends Model
{
    protected $fillable = [
        'task_id',
        'title',
        'description',
        'completed',
        'order'
    ];

    protected $casts = [
        'completed' => 'boolean'
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function scopePending($query)
    {
        return $query->where('completed', false);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
    }
}
