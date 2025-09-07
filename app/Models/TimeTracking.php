<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class TimeTracking extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'session_name',
        'description',
        'started_at',
        'ended_at',
        'duration_minutes',
        'status',
        'pause_periods'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'pause_periods' => 'array',
        'duration_minutes' => 'integer'
    ];

    // Relacionamentos
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('started_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('started_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    // Métodos de cálculo
    public function getElapsedTimeAttribute(): int
    {
        if ($this->status === 'completed' && $this->ended_at) {
            return $this->duration_minutes;
        }

        if ($this->status === 'active') {
            $totalMinutes = $this->started_at->diffInMinutes(now());
            $pauseMinutes = $this->getTotalPauseMinutes();
            return max(0, $totalMinutes - $pauseMinutes);
        }

        return 0;
    }

    public function getFormattedElapsedTimeAttribute(): string
    {
        $minutes = $this->elapsed_time;
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        
        if ($hours > 0) {
            return sprintf('%02d:%02d', $hours, $mins);
        }
        
        return sprintf('00:%02d', $mins);
    }

    public function getTotalPauseMinutes(): int
    {
        if (!$this->pause_periods) {
            return 0;
        }

        $totalPauseMinutes = 0;
        foreach ($this->pause_periods as $pause) {
            if (isset($pause['start']) && isset($pause['end'])) {
                $start = Carbon::parse($pause['start']);
                $end = Carbon::parse($pause['end']);
                $totalPauseMinutes += $start->diffInMinutes($end);
            }
        }

        return $totalPauseMinutes;
    }

    // Métodos de controle
    public function start(): void
    {
        $this->update([
            'status' => 'active',
            'started_at' => now(),
            'ended_at' => null
        ]);
    }

    public function pause(): void
    {
        if ($this->status === 'active') {
            $pausePeriods = $this->pause_periods ?? [];
            $pausePeriods[] = [
                'start' => now()->toISOString(),
                'end' => null
            ];

            $this->update([
                'status' => 'paused',
                'pause_periods' => $pausePeriods
            ]);
        }
    }

    public function resume(): void
    {
        if ($this->status === 'paused' && $this->pause_periods) {
            $pausePeriods = $this->pause_periods;
            $lastPause = end($pausePeriods);
            
            if ($lastPause && !isset($lastPause['end'])) {
                $lastPause['end'] = now()->toISOString();
                $pausePeriods[count($pausePeriods) - 1] = $lastPause;
            }

            $this->update([
                'status' => 'active',
                'pause_periods' => $pausePeriods
            ]);
        }
    }

    public function stop(): void
    {
        $this->update([
            'status' => 'completed',
            'ended_at' => now(),
            'duration_minutes' => $this->elapsed_time
        ]);
    }
}
