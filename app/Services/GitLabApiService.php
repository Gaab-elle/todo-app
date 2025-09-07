<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GitLabApiService
{
    private $token;
    private $baseUrl = 'https://gitlab.com/api/v4';

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
                'Authorization' => 'Bearer ' . $this->token
            ])->get($this->baseUrl . '/user');

            if ($repository) {
                $projectId = $this->getProjectId($repository);
                if ($projectId) {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $this->token
                    ])->get($this->baseUrl . '/projects/' . $projectId);
                }
            }

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('GitLab API connection test failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obter informações do repositório
     */
    public function getRepositoryInfo($repository): array
    {
        try {
            $projectId = $this->getProjectId($repository);
            if (!$projectId) {
                throw new \Exception('Project not found');
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token
            ])->get($this->baseUrl . '/projects/' . $projectId);

            if (!$response->successful()) {
                throw new \Exception('Failed to fetch repository info');
            }

            $data = $response->json();
            
            return [
                'name' => $data['name'],
                'full_name' => $data['path_with_namespace'],
                'description' => $data['description'],
                'language' => $data['default_branch'] ? $this->getRepositoryLanguages($projectId) : null,
                'languages' => $this->getRepositoryLanguages($projectId),
                'stars' => $data['star_count'],
                'forks' => $data['forks_count'],
                'open_issues' => $data['open_issues_count'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['last_activity_at'],
                'pushed_at' => $data['last_activity_at'],
                'default_branch' => $data['default_branch'],
                'private' => !$data['visibility'] === 'public',
                'owner' => [
                    'login' => $data['namespace']['name'],
                    'type' => $data['namespace']['kind']
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
    public function getRepositoryLanguages($projectId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token
            ])->get($this->baseUrl . '/projects/' . $projectId . '/languages');

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
            $projectId = $this->getProjectId($repository);
            if (!$projectId) {
                throw new \Exception('Project not found');
            }

            $params = [
                'per_page' => $perPage,
                'page' => 1
            ];

            if ($since) {
                $params['since'] = $since;
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token
            ])->get($this->baseUrl . '/projects/' . $projectId . '/repository/commits', $params);

            if (!$response->successful()) {
                throw new \Exception('Failed to fetch commits');
            }

            $commits = $response->json();
            $formattedCommits = [];

            foreach ($commits as $commit) {
                $formattedCommits[] = [
                    'sha' => $commit['id'],
                    'message' => $commit['message'],
                    'description' => $this->extractCommitDescription($commit['message']),
                    'author' => [
                        'name' => $commit['author_name'],
                        'email' => $commit['author_email'],
                        'username' => $commit['author_name'] // GitLab não tem username separado
                    ],
                    'committed_at' => $commit['created_at'],
                    'branch' => $this->getCommitBranch($projectId, $commit['id']),
                    'files' => $this->getCommitFiles($projectId, $commit['id']),
                    'stats' => $this->getCommitStats($projectId, $commit['id']),
                    'is_merge' => $this->isMergeCommit($commit['message']),
                    'parent_sha' => $commit['parent_ids'][0] ?? null,
                    'metadata' => [
                        'web_url' => $commit['web_url']
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
    private function getCommitFiles($projectId, $sha): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token
            ])->get($this->baseUrl . '/projects/' . $projectId . '/repository/commits/' . $sha . '/diff');

            if (!$response->successful()) {
                return [];
            }

            $files = $response->json();
            $formattedFiles = [];

            foreach ($files as $file) {
                $formattedFiles[] = [
                    'filename' => $file['new_path'] ?: $file['old_path'],
                    'status' => $this->getFileStatus($file),
                    'additions' => $file['additions'],
                    'deletions' => $file['deletions'],
                    'changes' => $file['additions'] + $file['deletions']
                ];
            }

            return $formattedFiles;
        } catch (\Exception $e) {
            Log::error('Failed to get commit files: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obter estatísticas de um commit
     */
    private function getCommitStats($projectId, $sha): array
    {
        try {
            $files = $this->getCommitFiles($projectId, $sha);
            
            $additions = 0;
            $deletions = 0;
            
            foreach ($files as $file) {
                $additions += $file['additions'];
                $deletions += $file['deletions'];
            }

            return [
                'additions' => $additions,
                'deletions' => $deletions,
                'total' => count($files)
            ];
        } catch (\Exception $e) {
            Log::error('Failed to get commit stats: ' . $e->getMessage());
            return ['additions' => 0, 'deletions' => 0, 'total' => 0];
        }
    }

    /**
     * Obter branch de um commit
     */
    private function getCommitBranch($projectId, $sha): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token
            ])->get($this->baseUrl . '/projects/' . $projectId . '/repository/commits/' . $sha . '/refs');

            if (!$response->successful()) {
                return null;
            }

            $refs = $response->json();
            
            foreach ($refs as $ref) {
                if ($ref['type'] === 'branch') {
                    return $ref['name'];
                }
            }

            return null;
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
            $projectId = $this->getProjectId($repository);
            if (!$projectId) {
                throw new \Exception('Project not found');
            }

            $payload = [
                'url' => $webhookUrl,
                'push_events' => true,
                'merge_requests_events' => true,
                'issues_events' => true,
                'enable_ssl_verification' => true
            ];

            if ($secret) {
                $payload['token'] = $secret;
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token
            ])->post($this->baseUrl . '/projects/' . $projectId . '/hooks', $payload);

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
            $projectId = $this->getProjectId($repository);
            if (!$projectId) {
                return false;
            }

            // Primeiro, obter a lista de webhooks
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token
            ])->get($this->baseUrl . '/projects/' . $projectId . '/hooks');

            if (!$response->successful()) {
                return false;
            }

            $webhooks = $response->json();
            
            foreach ($webhooks as $webhook) {
                if (str_contains($webhook['url'], parse_url($webhookUrl, PHP_URL_HOST))) {
                    $deleteResponse = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $this->token
                    ])->delete($this->baseUrl . '/projects/' . $projectId . '/hooks/' . $webhook['id']);

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
     * Obter ID do projeto pelo nome
     */
    private function getProjectId($repository): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token
            ])->get($this->baseUrl . '/projects/' . urlencode($repository));

            if ($response->successful()) {
                $data = $response->json();
                return (string) $data['id'];
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Failed to get project ID: ' . $e->getMessage());
            return null;
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
        return str_contains($message, 'Merge branch') || 
               str_contains($message, 'Merge request');
    }

    /**
     * Obter status do arquivo baseado nas mudanças
     */
    private function getFileStatus($file): string
    {
        if ($file['new_file']) return 'added';
        if ($file['deleted_file']) return 'deleted';
        if ($file['renamed_file']) return 'renamed';
        return 'modified';
    }
}
