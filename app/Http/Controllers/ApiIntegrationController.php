<?php

namespace App\Http\Controllers;

use App\Models\ApiIntegration;
use App\Models\Project;
use App\Models\RepositoryCommit;
use App\Services\GitHubApiService;
use App\Services\GitLabApiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ApiIntegrationController extends Controller
{
    /**
     * Listar integrações de um projeto
     */
    public function index(Request $request, Project $project): JsonResponse
    {
        $integrations = $project->apiIntegrations()
            ->where('user_id', auth()->id())
            ->get()
            ->map(function ($integration) {
                return [
                    'id' => $integration->id,
                    'provider' => $integration->provider,
                    'repository_name' => $integration->repository_name,
                    'repository_full_name' => $integration->repository_full_name,
                    'repository_url' => $integration->getRepositoryUrl(),
                    'is_active' => $integration->is_active,
                    'auto_tracking' => $integration->auto_tracking,
                    'sync_commits' => $integration->sync_commits,
                    'sync_issues' => $integration->sync_issues,
                    'sync_pull_requests' => $integration->sync_pull_requests,
                    'last_sync_at' => $integration->last_sync_at?->toISOString(),
                    'created_at' => $integration->created_at->toISOString()
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $integrations
        ]);
    }

    /**
     * Criar nova integração
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'provider' => 'required|in:github,gitlab',
            'repository_full_name' => 'required|string',
            'access_token' => 'required|string',
            'auto_tracking' => 'boolean',
            'sync_commits' => 'boolean',
            'sync_issues' => 'boolean',
            'sync_pull_requests' => 'boolean'
        ]);

        // Verificar se já existe integração para este repositório
        $existingIntegration = ApiIntegration::where('project_id', $request->project_id)
            ->where('repository_full_name', $request->repository_full_name)
            ->where('provider', $request->provider)
            ->first();

        if ($existingIntegration) {
            return response()->json([
                'success' => false,
                'message' => 'Já existe uma integração para este repositório'
            ], 400);
        }

        // Testar conexão com a API
        $apiService = $this->getApiService($request->provider, $request->access_token);
        if (!$apiService->testConnection($request->repository_full_name)) {
            return response()->json([
                'success' => false,
                'message' => 'Falha na conexão com a API. Verifique o token e o nome do repositório.'
            ], 400);
        }

        // Obter informações do repositório
        $repoInfo = $apiService->getRepositoryInfo($request->repository_full_name);
        if (empty($repoInfo)) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível obter informações do repositório'
            ], 400);
        }

        // Criar integração
        $integration = ApiIntegration::create([
            'project_id' => $request->project_id,
            'user_id' => auth()->id(),
            'provider' => $request->provider,
            'repository_owner' => $repoInfo['owner']['login'],
            'repository_name' => $repoInfo['name'],
            'repository_full_name' => $request->repository_full_name,
            'access_token' => $request->access_token,
            'is_active' => true,
            'auto_tracking' => $request->get('auto_tracking', true),
            'sync_commits' => $request->get('sync_commits', true),
            'sync_issues' => $request->get('sync_issues', false),
            'sync_pull_requests' => $request->get('sync_pull_requests', false),
            'settings' => [
                'repository_info' => $repoInfo,
                'webhook_secret' => Str::random(32)
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Integração criada com sucesso',
            'data' => [
                'id' => $integration->id,
                'provider' => $integration->provider,
                'repository_name' => $integration->repository_name,
                'repository_url' => $integration->getRepositoryUrl(),
                'is_active' => $integration->is_active
            ]
        ]);
    }

    /**
     * Obter serviço de API baseado no provedor
     */
    private function getApiService(string $provider, string $token)
    {
        switch ($provider) {
            case 'github':
                return new GitHubApiService($token);
            case 'gitlab':
                return new GitLabApiService($token);
            default:
                throw new \InvalidArgumentException("Provider não suportado: {$provider}");
        }
    }
}