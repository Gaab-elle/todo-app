<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GitHubApiService
{
    private $token;
    private $baseUrl = 'https://api.github.com';

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Testar conexão com a API
     */
    public function testConnection($repository = null): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'token ' . $this->token,
                'Accept' => 'application/vnd.github.v3+json'
            ])->get($this->baseUrl . '/user');

            if ($repository) {
                $response = Http::withHeaders([
                    'Authorization' => 'token ' . $this->token,
                    'Accept' => 'application/vnd.github.v3+json'
                ])->get($this->baseUrl . '/repos/' . $repository);
            }

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('GitHub API connection test failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obter informações do repositório
     */
    public function getRepositoryInfo($repository): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'token ' . $this->token,
                'Accept' => 'application/vnd.github.v3+json'
            ])->get($this->baseUrl . '/repos/' . $repository);

            if (!$response->successful()) {
                throw new \Exception('Failed to fetch repository info');
            }

            $data = $response->json();
            
            return [
                'name' => $data['name'],
                'full_name' => $data['full_name'],
                'description' => $data['description'],
                'language' => $data['language'],
                'languages' => $this->getRepositoryLanguages($repository),
                'stars' => $data['stargazers_count'],
                'forks' => $data['forks_count'],
                'open_issues' => $data['open_issues_count'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
                'pushed_at' => $data['pushed_at'],
                'default_branch' => $data['default_branch'],
                'private' => $data['private'],
                'owner' => [
                    'login' => $data['owner']['login'],
                    'type' => $data['owner']['type']
                ]
            ];
        } catch (\Exception $e) {
            Log::error('Failed to get repository info: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obter linguagens do repositório
     */
    public function getRepositoryLanguages($repository): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'token ' . $this->token,
                'Accept' => 'application/vnd.github.v3+json'
            ])->get($this->baseUrl . '/repos/' . $repository . '/languages');

            if (!$response->successful()) {
                return [];
            }

            return array_keys($response->json());
        } catch (\Exception $e) {
            Log::error('Failed to get repository languages: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obter commits do repositório
     */
    public function getCommits($repository, $since = null, $perPage = 100): array
    {
        try {
            $params = [
                'per_page' => $perPage,
                'page' => 1
            ];

            if ($since) {
                $params['since'] = $since;
            }

            $response = Http::withHeaders([
                'Authorization' => 'token ' . $this->token,
                'Accept' => 'application/vnd.github.v3+json'
            ])->get($this->baseUrl . '/repos/' . $repository . '/commits', $params);

            if (!$response->successful()) {
                throw new \Exception('Failed to fetch commits');
            }

            $commits = $response->json();
            $formattedCommits = [];

            foreach ($commits as $commit) {
                $formattedCommits[] = [
                    'sha' => $commit['sha'],
                    'message' => $commit['commit']['message'],
                    'description' => $this->extractCommitDescription($commit['commit']['message']),
                    'author' => [
                        'name' => $commit['commit']['author']['name'],
                        'email' => $commit['commit']['author']['email'],
                        'username' => $commit['author']['login'] ?? null
                    ],
                    'committed_at' => $commit['commit']['author']['date'],
                    'branch' => $this->getCommitBranch($repository, $commit['sha']),
                    'files' => $this->getCommitFiles($repository, $commit['sha']),
                    'stats' => $this->getCommitStats($repository, $commit['sha']),
                    'is_merge' => $this->isMergeCommit($commit['commit']['message']),
                    'parent_sha' => $commit['parents'][0]['sha'] ?? null,
                    'metadata' => [
                        'html_url' => $commit['html_url'],
                        'comments_url' => $commit['comments_url']
                    ]
                ];
            }

            return $formattedCommits;
        } catch (\Exception $e) {
            Log::error('Failed to get commits: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obter arquivos modificados em um commit
     */
    private function getCommitFiles($repository, $sha): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'token ' . $this->token,
                'Accept' => 'application/vnd.github.v3+json'
            ])->get($this->baseUrl . '/repos/' . $repository . '/commits/' . $sha);

            if (!$response->successful()) {
                return [];
            }

            $commit = $response->json();
            $files = [];

            foreach ($commit['files'] as $file) {
                $files[] = [
                    'filename' => $file['filename'],
                    'status' => $file['status'],
                    'additions' => $file['additions'],
                    'deletions' => $file['deletions'],
                    'changes' => $file['changes']
                ];
            }

            return $files;
        } catch (\Exception $e) {
            Log::error('Failed to get commit files: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obter estatísticas de um commit
     */
    private function getCommitStats($repository, $sha): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'token ' . $this->token,
                'Accept' => 'application/vnd.github.v3+json'
            ])->get($this->baseUrl . '/repos/' . $repository . '/commits/' . $sha);

            if (!$response->successful()) {
                return ['additions' => 0, 'deletions' => 0, 'total' => 0];
            }

            $commit = $response->json();
            $stats = $commit['stats'];

            return [
                'additions' => $stats['additions'],
                'deletions' => $stats['deletions'],
                'total' => $stats['total']
            ];
        } catch (\Exception $e) {
            Log::error('Failed to get commit stats: ' . $e->getMessage());
            return ['additions' => 0, 'deletions' => 0, 'total' => 0];
        }
    }

    /**
     * Obter branch de um commit
     */
    private function getCommitBranch($repository, $sha): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'token ' . $this->token,
                'Accept' => 'application/vnd.github.v3+json'
            ])->get($this->baseUrl . '/repos/' . $repository . '/commits/' . $sha . '/branches-where-head');

            if (!$response->successful()) {
                return null;
            }

            $branches = $response->json();
            return $branches[0]['name'] ?? null;
        } catch (\Exception $e) {
            Log::error('Failed to get commit branch: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Criar webhook
     */
    public function createWebhook($repository, $webhookUrl, $secret = null): array
    {
        try {
            $payload = [
                'name' => 'web',
                'active' => true,
                'events' => ['push', 'pull_request', 'issues'],
                'config' => [
                    'url' => $webhookUrl,
                    'content_type' => 'json'
                ]
            ];

            if ($secret) {
                $payload['config']['secret'] = $secret;
            }

            $response = Http::withHeaders([
                'Authorization' => 'token ' . $this->token,
                'Accept' => 'application/vnd.github.v3+json'
            ])->post($this->baseUrl . '/repos/' . $repository . '/hooks', $payload);

            if (!$response->successful()) {
                throw new \Exception('Failed to create webhook');
            }

            $webhook = $response->json();
            
            return [
                'id' => $webhook['id'],
                'url' => $webhook['url'],
                'secret' => $secret
            ];
        } catch (\Exception $e) {
            Log::error('Failed to create webhook: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Deletar webhook
     */
    public function deleteWebhook($repository, $webhookUrl): bool
    {
        try {
            // Primeiro, obter a lista de webhooks
            $response = Http::withHeaders([
                'Authorization' => 'token ' . $this->token,
                'Accept' => 'application/vnd.github.v3+json'
            ])->get($this->baseUrl . '/repos/' . $repository . '/hooks');

            if (!$response->successful()) {
                return false;
            }

            $webhooks = $response->json();
            
            foreach ($webhooks as $webhook) {
                if (str_contains($webhook['config']['url'], parse_url($webhookUrl, PHP_URL_HOST))) {
                    $deleteResponse = Http::withHeaders([
                        'Authorization' => 'token ' . $this->token,
                        'Accept' => 'application/vnd.github.v3+json'
                    ])->delete($this->baseUrl . '/repos/' . $repository . '/hooks/' . $webhook['id']);

                    return $deleteResponse->successful();
                }
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to delete webhook: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Extrair descrição do commit (após a primeira linha)
     */
    private function extractCommitDescription($message): ?string
    {
        $lines = explode("\n", $message);
        if (count($lines) > 1) {
            $description = trim(implode("\n", array_slice($lines, 1)));
            return !empty($description) ? $description : null;
        }
        return null;
    }

    /**
     * Verificar se é um merge commit
     */
    private function isMergeCommit($message): bool
    {
        return str_starts_with($message, 'Merge pull request') || 
               str_starts_with($message, 'Merge branch');
    }
}
