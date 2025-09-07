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
        'is_favorite',
        'task_type',
        'programming_language',
        'estimated_time',
        'actual_time',
        'complexity',
        'repository_branch',
        'issue_number',
        'pull_request_url',
        'user_id'
    ];

    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'datetime',
        'tags' => 'array',
        'is_favorite' => 'boolean',
        'estimated_time' => 'integer',
        'actual_time' => 'integer'
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

    public function scopeUrgent($query)
    {
        return $query->where(function ($q) {
            $q->where('priority', 'high')
              ->orWhere(function ($subQ) {
                  // Tarefas com prazo vencendo hoje ou já vencidas
                  $subQ->whereNotNull('due_date')
                       ->whereDate('due_date', '<=', now()->toDateString())
                       ->where('completed', false);
              })
              ->orWhere(function ($subQ) {
                  // Tarefas com prazo vencendo nos próximos 2 dias
                  $subQ->whereNotNull('due_date')
                       ->whereDate('due_date', '<=', now()->addDays(2)->toDateString())
                       ->where('completed', false)
                       ->where('priority', 'medium');
              });
        });
    }

    public function scopeDueToday($query)
    {
        return $query->whereNotNull('due_date')
                    ->whereDate('due_date', now()->toDateString())
                    ->where('completed', false);
    }

    public function scopeOverdue($query)
    {
        return $query->whereNotNull('due_date')
                    ->whereDate('due_date', '<', now()->toDateString())
                    ->where('completed', false);
    }

    public function getIsUrgentAttribute()
    {
        // Tarefa é urgente se:
        // 1. Prioridade alta
        // 2. Prazo vencido
        // 3. Prazo vencendo hoje
        // 4. Prazo vencendo em 2 dias e prioridade média
        
        if ($this->priority === 'high') {
            return true;
        }
        
        if (!$this->due_date) {
            return false;
        }
        
        $dueDate = $this->due_date->toDateString();
        $today = now()->toDateString();
        $twoDaysFromNow = now()->addDays(2)->toDateString();
        
        // Vencida
        if ($dueDate < $today) {
            return true;
        }
        
        // Vence hoje
        if ($dueDate === $today) {
            return true;
        }
        
        // Vence em 2 dias e é prioridade média
        if ($dueDate <= $twoDaysFromNow && $this->priority === 'medium') {
            return true;
        }
        
        return false;
    }

    public function getUrgencyLevelAttribute()
    {
        if (!$this->due_date) {
            return $this->priority === 'high' ? 'high' : 'normal';
        }
        
        $dueDate = $this->due_date->toDateString();
        $today = now()->toDateString();
        $twoDaysFromNow = now()->addDays(2)->toDateString();
        
        // Vencida
        if ($dueDate < $today) {
            return 'overdue';
        }
        
        // Vence hoje
        if ($dueDate === $today) {
            return 'due_today';
        }
        
        // Vence em 2 dias
        if ($dueDate <= $twoDaysFromNow) {
            return 'due_soon';
        }
        
        return $this->priority === 'high' ? 'high' : 'normal';
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