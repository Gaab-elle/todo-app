<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color',
        'icon',
        'is_active',
        'is_favorite',
        'project_type',
        'programming_languages',
        'technologies_used',
        'repository_url',
        'development_status',
        'time_spent',
        'start_date',
        'end_date',
        'category',
        'user_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_favorite' => 'boolean',
        'programming_languages' => 'array',
        'technologies_used' => 'array',
        'time_spent' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function timeTrackings(): HasMany
    {
        return $this->hasMany(TimeTracking::class);
    }

    public function apiIntegrations(): HasMany
    {
        return $this->hasMany(ApiIntegration::class);
    }

    public function repositoryCommits(): HasMany
    {
        return $this->hasMany(RepositoryCommit::class);
    }

    public function templates(): HasMany
    {
        return $this->hasMany(TaskTemplate::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFavorites($query)
    {
        return $query->where('is_favorite', true);
    }
}
