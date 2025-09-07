<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GitHubService
{
    private $baseUrl = 'https://api.github.com';
    private $token;

    public function __construct()
    {
        $this->token = config('services.github.token');
    }

    /**
     * Get user profile information
     */
    public function getUserProfile($username)
    {
        return Cache::remember("github_user_{$username}", 3600, function () use ($username) {
            try {
                $response = Http::withHeaders([
                    'Accept' => 'application/vnd.github.v3+json',
                    'Authorization' => $this->token ? "token {$this->token}" : null,
                ])->get("{$this->baseUrl}/users/{$username}");

                if ($response->successful()) {
                    return $response->json();
                }

                Log::error("GitHub API Error for user {$username}: " . $response->body());
                return null;
            } catch (\Exception $e) {
                Log::error("GitHub API Exception for user {$username}: " . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Get user repositories
     */
    public function getUserRepositories($username, $perPage = 100)
    {
        return Cache::remember("github_repos_{$username}_{$perPage}", 1800, function () use ($username, $perPage) {
            try {
                $response = Http::withHeaders([
                    'Accept' => 'application/vnd.github.v3+json',
                    'Authorization' => $this->token ? "token {$this->token}" : null,
                ])->get("{$this->baseUrl}/users/{$username}/repos", [
                    'sort' => 'updated',
                    'per_page' => $perPage,
                    'type' => 'owner'
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                Log::error("GitHub API Error for repos {$username}: " . $response->body());
                return [];
            } catch (\Exception $e) {
                Log::error("GitHub API Exception for repos {$username}: " . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get repository languages
     */
    public function getRepositoryLanguages($username, $repoName)
    {
        return Cache::remember("github_langs_{$username}_{$repoName}", 3600, function () use ($username, $repoName) {
            try {
                $response = Http::withHeaders([
                    'Accept' => 'application/vnd.github.v3+json',
                    'Authorization' => $this->token ? "token {$this->token}" : null,
                ])->get("{$this->baseUrl}/repos/{$username}/{$repoName}/languages");

                if ($response->successful()) {
                    return $response->json();
                }

                return [];
            } catch (\Exception $e) {
                Log::error("GitHub API Exception for languages {$username}/{$repoName}: " . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get user contribution statistics
     */
    public function getUserContributions($username)
    {
        return Cache::remember("github_contributions_{$username}", 3600, function () use ($username) {
            try {
                // GitHub doesn't have a direct API for contribution graph
                // We'll use a web scraping approach or third-party service
                $response = Http::get("https://github-contributions-api.vercel.app/{$username}");

                if ($response->successful()) {
                    return $response->json();
                }

                return null;
            } catch (\Exception $e) {
                Log::error("GitHub Contributions Exception for {$username}: " . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Get repository statistics
     */
    public function getRepositoryStats($username, $repoName)
    {
        return Cache::remember("github_repo_stats_{$username}_{$repoName}", 1800, function () use ($username, $repoName) {
            try {
                $response = Http::withHeaders([
                    'Accept' => 'application/vnd.github.v3+json',
                    'Authorization' => $this->token ? "token {$this->token}" : null,
                ])->get("{$this->baseUrl}/repos/{$username}/{$repoName}/stats/contributors");

                if ($response->successful()) {
                    return $response->json();
                }

                return [];
            } catch (\Exception $e) {
                Log::error("GitHub API Exception for repo stats {$username}/{$repoName}: " . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get user's programming languages summary
     */
    public function getUserLanguagesSummary($username)
    {
        $repositories = $this->getUserRepositories($username);
        $languages = [];

        foreach ($repositories as $repo) {
            if (!$repo['fork']) { // Only count original repositories
                $repoLanguages = $this->getRepositoryLanguages($username, $repo['name']);
                foreach ($repoLanguages as $language => $bytes) {
                    $languages[$language] = ($languages[$language] ?? 0) + $bytes;
                }
            }
        }

        // Sort by usage
        arsort($languages);
        
        return $languages;
    }

    /**
     * Get user's repository statistics
     */
    public function getUserRepositoryStats($username)
    {
        $repositories = $this->getUserRepositories($username);
        
        $stats = [
            'total_repos' => count($repositories),
            'public_repos' => 0,
            'private_repos' => 0,
            'forks' => 0,
            'stars' => 0,
            'watchers' => 0,
            'total_size' => 0,
            'languages' => [],
            'topics' => []
        ];

        foreach ($repositories as $repo) {
            if ($repo['private']) {
                $stats['private_repos']++;
            } else {
                $stats['public_repos']++;
            }

            $stats['forks'] += $repo['forks_count'];
            $stats['stars'] += $repo['stargazers_count'];
            $stats['watchers'] += $repo['watchers_count'];
            $stats['total_size'] += $repo['size'];

            // Get languages for this repo
            $repoLanguages = $this->getRepositoryLanguages($username, $repo['name']);
            foreach ($repoLanguages as $language => $bytes) {
                $stats['languages'][$language] = ($stats['languages'][$language] ?? 0) + $bytes;
            }

            // Collect topics
            if (!empty($repo['topics'])) {
                foreach ($repo['topics'] as $topic) {
                    $stats['topics'][$topic] = ($stats['topics'][$topic] ?? 0) + 1;
                }
            }
        }

        // Sort languages and topics
        arsort($stats['languages']);
        arsort($stats['topics']);

        return $stats;
    }

    /**
     * Clear cache for a user
     */
    public function clearUserCache($username)
    {
        Cache::forget("github_user_{$username}");
        Cache::forget("github_repos_{$username}_100");
        Cache::forget("github_contributions_{$username}");
        
        // Clear repository-specific caches
        $repositories = $this->getUserRepositories($username);
        foreach ($repositories as $repo) {
            Cache::forget("github_langs_{$username}_{$repo['name']}");
            Cache::forget("github_repo_stats_{$username}_{$repo['name']}");
        }
    }
}
