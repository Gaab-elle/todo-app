<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GitHubService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PublicProfileController extends Controller
{
    /**
     * Show public profile by username or ID.
     */
    public function show(Request $request, $identifier)
    {
        // Try to find user by username first, then by ID
        $user = User::where('username', $identifier)
            ->orWhere('id', $identifier)
            ->where('is_public', true)
            ->first();

        if (!$user) {
            abort(404, 'Perfil não encontrado ou não está público.');
        }

        // Get user's public projects
        $projects = $user->projects()
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Get GitHub data if user has GitHub username
        $githubService = new GitHubService();
        $githubData = null;
        $githubStats = null;
        $githubRepos = null;
        $githubLanguages = null;

        if ($user->github_username) {
            $githubData = $githubService->getUserProfile($user->github_username);
            $githubStats = $githubService->getUserRepositoryStats($user->github_username);
            $githubRepos = $githubService->getUserRepositories($user->github_username, 6);
            $githubLanguages = $githubService->getUserLanguagesSummary($user->github_username);
        }

        // Get user's skills
        $skills = $user->skills ?? [];

        // Get user's experience
        $experience = $user->experience ?? [];

        // Get public stats
        $stats = $user->public_stats;

        return view('profile.public', compact(
            'user',
            'projects',
            'skills',
            'experience',
            'stats',
            'githubData',
            'githubStats',
            'githubRepos',
            'githubLanguages'
        ));
    }

    /**
     * Get GitHub data for user.
     */
    private function getGithubData(User $user): array
    {
        try {
            // This will be implemented with GitHub API
            // For now, return mock data based on the user's GitHub profile
            return [
                'repositories_count' => 16,
                'total_commits' => 79,
                'total_stars' => 3,
                'total_prs' => 0,
                'total_issues' => 0,
                'contributed_to' => 0,
                'languages' => [
                    'Python' => 90.26,
                    'Blade' => 2.94,
                    'JavaScript' => 1.87,
                    'PHP' => 1.41,
                    'Vue' => 1.30,
                    'HTML' => 1.24,
                    'CSS' => 0.99
                ],
                'contributions' => [
                    'last_year' => 97,
                    'current_year' => 97
                ],
                'last_activity' => now()->subDays(2),
            ];
        } catch (\Exception $e) {
            return [
                'repositories_count' => 0,
                'total_commits' => 0,
                'total_stars' => 0,
                'total_prs' => 0,
                'total_issues' => 0,
                'contributed_to' => 0,
                'languages' => [],
                'contributions' => [],
                'last_activity' => null,
                'error' => 'Erro ao carregar dados do GitHub'
            ];
        }
    }

    /**
     * Get user's projects for public profile.
     */
    public function projects(Request $request, $identifier): JsonResponse
    {
        $user = User::where('username', $identifier)
            ->orWhere('id', $identifier)
            ->where('is_public', true)
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Perfil não encontrado'], 404);
        }

        $projects = $user->projects()
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return response()->json([
            'success' => true,
            'projects' => $projects
        ]);
    }

    /**
     * Get user's GitHub stats.
     */
    public function githubStats(Request $request, $identifier): JsonResponse
    {
        $user = User::where('username', $identifier)
            ->orWhere('id', $identifier)
            ->where('is_public', true)
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Perfil não encontrado'], 404);
        }

        if (!$user->hasGithubIntegration()) {
            return response()->json(['error' => 'GitHub não conectado'], 400);
        }

        $githubData = $this->getGithubData($user);

        return response()->json([
            'success' => true,
            'data' => $githubData
        ]);
    }

    /**
     * Search public profiles.
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $type = $request->get('type', 'all'); // all, professional, personal
        $location = $request->get('location', '');

        $users = User::public()
            ->when($type !== 'all', function ($q) use ($type) {
                return $q->where('profile_type', $type);
            })
            ->when($location, function ($q) use ($location) {
                return $q->where('location', 'like', "%{$location}%");
            })
            ->when($query, function ($q) use ($query) {
                return $q->where(function ($subQ) use ($query) {
                    $subQ->where('name', 'like', "%{$query}%")
                        ->orWhere('username', 'like', "%{$query}%")
                        ->orWhere('bio', 'like', "%{$query}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('profile.search', compact('users', 'query', 'type', 'location'));
    }

    /**
     * Get trending developers.
     */
    public function trending(): JsonResponse
    {
        $trending = User::public()
            ->withCount(['projects', 'tasks'])
            ->orderBy('projects_count', 'desc')
            ->orderBy('tasks_count', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'trending' => $trending
        ]);
    }
}