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
        'is_favorite'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_favorite' => 'boolean'
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
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
