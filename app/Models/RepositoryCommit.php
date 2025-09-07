<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class RepositoryCommit extends Model
{
    protected $fillable = [
        'project_id',
        'api_integration_id',
        'commit_sha',
        'commit_message',
        'commit_description',
        'author_name',
        'author_email',
        'author_username',
        'committed_at',
        'branch_name',
        'files_changed',
        'lines_added',
        'lines_deleted',
        'files_changed_count',
        'is_merge_commit',
        'parent_sha',
        'metadata'
    ];

    protected $casts = [
        'committed_at' => 'datetime',
        'files_changed' => 'array',
        'metadata' => 'array',
        'is_merge_commit' => 'boolean',
        'lines_added' => 'integer',
        'lines_deleted' => 'integer',
        'files_changed_count' => 'integer'
    ];

    // Relacionamentos
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function apiIntegration(): BelongsTo
    {
        return $this->belongsTo(ApiIntegration::class);
    }

    // Scopes
    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeForAuthor($query, $email)
    {
        return $query->where('author_email', $email);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('committed_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('committed_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('committed_at', now()->month)
                    ->whereYear('committed_at', now()->year);
    }

    public function scopeByBranch($query, $branch)
    {
        return $query->where('branch_name', $branch);
    }

    public function scopeExcludeMerges($query)
    {
        return $query->where('is_merge_commit', false);
    }

    // Accessors
    public function getShortShaAttribute(): string
    {
        return substr($this->commit_sha, 0, 7);
    }

    public function getShortMessageAttribute(): string
    {
        return strlen($this->commit_message) > 50 
            ? substr($this->commit_message, 0, 50) . '...'
            : $this->commit_message;
    }

    public function getCommitUrlAttribute(): string
    {
        $integration = $this->apiIntegration;
        if (!$integration) {
            return '';
        }

        switch ($integration->provider) {
            case 'github':
                return "https://github.com/{$integration->repository_full_name}/commit/{$this->commit_sha}";
            case 'gitlab':
                return "https://gitlab.com/{$integration->repository_full_name}/-/commit/{$this->commit_sha}";
            default:
                return '';
        }
    }

    public function getAuthorUrlAttribute(): string
    {
        $integration = $this->apiIntegration;
        if (!$integration || !$this->author_username) {
            return '';
        }

        switch ($integration->provider) {
            case 'github':
                return "https://github.com/{$this->author_username}";
            case 'gitlab':
                return "https://gitlab.com/{$this->author_username}";
            default:
                return '';
        }
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->committed_at->diffForHumans();
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->committed_at->format('d/m/Y H:i');
    }

    // Métodos de análise
    public function getImpactScore(): int
    {
        // Calcula um score de impacto baseado nas mudanças
        $score = 0;
        
        // Pontos por linhas modificadas
        $score += min($this->lines_added + $this->lines_deleted, 100);
        
        // Pontos por arquivos modificados
        $score += min($this->files_changed_count * 5, 50);
        
        // Penalidade para merge commits
        if ($this->is_merge_commit) {
            $score = max(0, $score - 20);
        }
        
        return min($score, 100);
    }

    public function getComplexityLevel(): string
    {
        $score = $this->getImpactScore();
        
        if ($score >= 80) return 'high';
        if ($score >= 50) return 'medium';
        return 'low';
    }

    public function getComplexityColor(): string
    {
        switch ($this->getComplexityLevel()) {
            case 'high': return 'red';
            case 'medium': return 'yellow';
            default: return 'green';
        }
    }

    // Métodos estáticos para estatísticas
    public static function getStatsForProject($projectId, $period = 'week')
    {
        $query = static::forProject($projectId);
        
        switch ($period) {
            case 'today':
                $query->today();
                break;
            case 'week':
                $query->thisWeek();
                break;
            case 'month':
                $query->thisMonth();
                break;
        }

        return [
            'total_commits' => $query->count(),
            'total_lines_added' => $query->sum('lines_added'),
            'total_lines_deleted' => $query->sum('lines_deleted'),
            'total_files_changed' => $query->sum('files_changed_count'),
            'unique_authors' => $query->distinct('author_email')->count('author_email'),
            'merge_commits' => $query->where('is_merge_commit', true)->count(),
            'average_impact_score' => $query->get()->avg(function($commit) {
                return $commit->getImpactScore();
            })
        ];
    }

    public static function getTopAuthors($projectId, $limit = 5)
    {
        return static::forProject($projectId)
            ->selectRaw('author_name, author_email, author_username, COUNT(*) as commit_count, SUM(lines_added) as total_lines_added')
            ->groupBy('author_name', 'author_email', 'author_username')
            ->orderBy('commit_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function getCommitsByDay($projectId, $days = 30)
    {
        return static::forProject($projectId)
            ->where('committed_at', '>=', now()->subDays($days))
            ->selectRaw('DATE(committed_at) as date, COUNT(*) as commit_count, SUM(lines_added) as lines_added, SUM(lines_deleted) as lines_deleted')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}