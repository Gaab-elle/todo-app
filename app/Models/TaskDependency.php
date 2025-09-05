<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskDependency extends Model
{
    protected $fillable = [
        'task_id',
        'depends_on_task_id',
        'type'
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function dependsOnTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'depends_on_task_id');
    }

    public function scopeBlocks($query)
    {
        return $query->where('type', 'blocks');
    }

    public function scopeFollows($query)
    {
        return $query->where('type', 'follows');
    }

    public function scopeRelates($query)
    {
        return $query->where('type', 'relates');
    }
}
