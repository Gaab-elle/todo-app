<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'completed',
        'priority',
        'due_date',
        'status',
        'tags',
        'project_id',
        'is_favorite'
    ];

    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'datetime',
        'tags' => 'array',
        'is_favorite' => 'boolean'
    ];

    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function scopePending($query)
    {
        return $query->where('completed', false);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhereJsonContains('tags', $search);
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function subtasks(): HasMany
    {
        return $this->hasMany(Subtask::class)->ordered();
    }

    public function dependencies(): HasMany
    {
        return $this->hasMany(TaskDependency::class);
    }

    public function dependents(): HasMany
    {
        return $this->hasMany(TaskDependency::class, 'depends_on_task_id');
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'high' => 'bg-red-100 text-red-800 border-red-200',
            'medium' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'low' => 'bg-green-100 text-green-800 border-green-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200'
        };
    }

    public function getCompletionPercentageAttribute()
    {
        $totalSubtasks = $this->subtasks()->count();
        if ($totalSubtasks === 0) {
            return $this->completed ? 100 : 0;
        }
        
        $completedSubtasks = $this->subtasks()->completed()->count();
        return round(($completedSubtasks / $totalSubtasks) * 100);
    }

    public function canBeCompleted()
    {
        // Check if all dependencies are completed
        $incompleteDependencies = $this->dependencies()
            ->whereHas('dependsOnTask', function($query) {
                $query->where('completed', false);
            })
            ->count();
            
        return $incompleteDependencies === 0;
    }
}