<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskTemplate extends Model
{
    protected $fillable = [
        'name',
        'description',
        'priority',
        'tags',
        'subtasks',
        'project_id',
        'is_active'
    ];

    protected $casts = [
        'tags' => 'array',
        'subtasks' => 'array',
        'is_active' => 'boolean'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function createTaskFromTemplate(array $additionalData = []): Task
    {
        $taskData = [
            'title' => $this->name,
            'description' => $this->description,
            'priority' => $this->priority,
            'tags' => $this->tags,
            'project_id' => $this->project_id,
            'status' => 'pending'
        ];

        $taskData = array_merge($taskData, $additionalData);

        $task = Task::create($taskData);

        // Create subtasks if template has them
        if ($this->subtasks) {
            foreach ($this->subtasks as $subtaskData) {
                $task->subtasks()->create([
                    'title' => $subtaskData['title'],
                    'description' => $subtaskData['description'] ?? null,
                    'order' => $subtaskData['order'] ?? 0
                ]);
            }
        }

        return $task;
    }
}
