<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;

class ApiIntegration extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'provider',
        'repository_owner',
        'repository_name',
        'repository_full_name',
        'access_token',
        'webhook_secret',
        'webhook_url',
        'is_active',
        'auto_tracking',
        'sync_commits',
        'sync_issues',
        'sync_pull_requests',
        'settings',
        'last_sync_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'auto_tracking' => 'boolean',
        'sync_commits' => 'boolean',
        'sync_issues' => 'boolean',
        'sync_pull_requests' => 'boolean',
        'settings' => 'array',
        'last_sync_at' => 'datetime'
    ];

    protected $hidden = [
        'access_token',
        'webhook_secret'
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

    public function commits(): HasMany
    {
        return $this->hasMany(RepositoryCommit::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForProvider($query, $provider)
    {
        return $query->where('provider', $provider);
    }

    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeWithAutoTracking($query)
    {
        return $query->where('auto_tracking', true);
    }

    // Accessors & Mutators
    public function getAccessTokenAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function setAccessTokenAttribute($value)
    {
        $this->attributes['access_token'] = $value ? Crypt::encryptString($value) : null;
    }

    public function getWebhookSecretAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function setWebhookSecretAttribute($value)
    {
        $this->attributes['webhook_secret'] = $value ? Crypt::encryptString($value) : null;
    }

    // Métodos de API
    public function getApiClient()
    {
        switch ($this->provider) {
            case 'github':
                return new \App\Services\GitHubApiService($this->access_token);
            case 'gitlab':
                return new \App\Services\GitLabApiService($this->access_token);
            default:
                throw new \InvalidArgumentException("Provider não suportado: {$this->provider}");
        }
    }

    public function getRepositoryUrl(): string
    {
        switch ($this->provider) {
            case 'github':
                return "https://github.com/{$this->repository_full_name}";
            case 'gitlab':
                return "https://gitlab.com/{$this->repository_full_name}";
            default:
                return '';
        }
    }

    public function getApiUrl(): string
    {
        switch ($this->provider) {
            case 'github':
                return "https://api.github.com/repos/{$this->repository_full_name}";
            case 'gitlab':
                return "https://gitlab.com/api/v4/projects/{$this->repository_full_name}";
            default:
                return '';
        }
    }

    // Métodos de sincronização
    public function syncCommits($since = null)
    {
        if (!$this->sync_commits) {
            return false;
        }

        try {
            $apiClient = $this->getApiClient();
            $commits = $apiClient->getCommits($this->repository_full_name, $since);

            foreach ($commits as $commitData) {
                $this->commits()->updateOrCreate(
                    ['commit_sha' => $commitData['sha']],
                    [
                        'project_id' => $this->project_id,
                        'commit_message' => $commitData['message'],
                        'commit_description' => $commitData['description'] ?? null,
                        'author_name' => $commitData['author']['name'],
                        'author_email' => $commitData['author']['email'],
                        'author_username' => $commitData['author']['username'] ?? null,
                        'committed_at' => $commitData['committed_at'],
                        'branch_name' => $commitData['branch'] ?? null,
                        'files_changed' => $commitData['files'] ?? null,
                        'lines_added' => $commitData['stats']['additions'] ?? 0,
                        'lines_deleted' => $commitData['stats']['deletions'] ?? 0,
                        'files_changed_count' => $commitData['stats']['total'] ?? 0,
                        'is_merge_commit' => $commitData['is_merge'] ?? false,
                        'parent_sha' => $commitData['parent_sha'] ?? null,
                        'metadata' => $commitData['metadata'] ?? null
                    ]
                );
            }

            $this->update(['last_sync_at' => now()]);
            return true;
        } catch (\Exception $e) {
            \Log::error("Erro ao sincronizar commits: " . $e->getMessage());
            return false;
        }
    }

    public function createWebhook()
    {
        try {
            $apiClient = $this->getApiClient();
            $webhookUrl = route('webhooks.integration', ['provider' => $this->provider]);
            
            $webhookData = $apiClient->createWebhook(
                $this->repository_full_name,
                $webhookUrl,
                $this->webhook_secret
            );

            $this->update([
                'webhook_url' => $webhookData['url'],
                'webhook_secret' => $webhookData['secret']
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error("Erro ao criar webhook: " . $e->getMessage());
            return false;
        }
    }

    public function deleteWebhook()
    {
        if (!$this->webhook_url) {
            return true;
        }

        try {
            $apiClient = $this->getApiClient();
            $apiClient->deleteWebhook($this->repository_full_name, $this->webhook_url);
            
            $this->update([
                'webhook_url' => null,
                'webhook_secret' => null
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error("Erro ao deletar webhook: " . $e->getMessage());
            return false;
        }
    }

    // Métodos de validação
    public function testConnection(): bool
    {
        try {
            $apiClient = $this->getApiClient();
            return $apiClient->testConnection($this->repository_full_name);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getRepositoryInfo(): array
    {
        try {
            $apiClient = $this->getApiClient();
            return $apiClient->getRepositoryInfo($this->repository_full_name);
        } catch (\Exception $e) {
            return [];
        }
    }
}