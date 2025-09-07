<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'is_public',
        'profile_type',
        'bio',
        'location',
        'website',
        'linkedin',
        'twitter',
        'github_username',
        'skills',
        'experience',
        'github_access_token',
        'github_synced_at',
        'profile_theme',
        'profile_settings',
        'username',
        'meta_description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_public' => 'boolean',
            'skills' => 'array',
            'experience' => 'array',
            'profile_settings' => 'array',
            'github_synced_at' => 'datetime',
        ];
    }

    /**
     * Get the projects for the user.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the tasks for the user.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the time trackings for the user.
     */
    public function timeTrackings(): HasMany
    {
        return $this->hasMany(TimeTracking::class);
    }

    /**
     * Get the user's avatar URL.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }
        
        // Fallback para avatar com inicial do nome
        return $this->getGravatarUrl();
    }

    /**
     * Get Gravatar URL as fallback.
     */
    public function getGravatarUrl(): string
    {
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=identicon&s=200";
    }

    /**
     * Get user's initials for avatar fallback.
     */
    public function getInitialsAttribute(): string
    {
        $name = $this->name ?? 'User';
        $words = explode(' ', $name);
        
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        
        return strtoupper(substr($name, 0, 2));
    }

    /**
     * Get the public profile URL.
     */
    public function getPublicProfileUrlAttribute(): string
    {
        if ($this->username) {
            return route('profile.public', ['username' => $this->username]);
        }
        
        return route('profile.public', ['id' => $this->id]);
    }

    /**
     * Get the profile display name.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->name ?? 'Desenvolvedor';
    }

    /**
     * Get the profile title based on type.
     */
    public function getProfileTitleAttribute(): string
    {
        if ($this->profile_type === 'professional') {
            return 'Desenvolvedor Profissional';
        }
        
        return 'Desenvolvedor';
    }

    /**
     * Check if profile has GitHub integration.
     */
    public function hasGithubIntegration(): bool
    {
        return !empty($this->github_username) && !empty($this->github_access_token);
    }

    /**
     * Get profile stats for public display.
     */
    public function getPublicStatsAttribute(): array
    {
        return [
            'projects_count' => $this->projects()->count(),
            'tasks_count' => $this->tasks()->count(),
            'time_tracked' => $this->timeTrackings()->sum('duration_minutes'),
            'member_since' => $this->created_at->format('M Y'),
        ];
    }

    /**
     * Scope for public profiles.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope for professional profiles.
     */
    public function scopeProfessional($query)
    {
        return $query->where('profile_type', 'professional');
    }

    /**
     * Scope for personal profiles.
     */
    public function scopePersonal($query)
    {
        return $query->where('profile_type', 'personal');
    }
}
