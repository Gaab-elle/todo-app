<?php

namespace App\Http\Controllers;

use App\Models\TimeTracking;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class TimeTrackingController extends Controller
{
    /**
     * Iniciar tracking de tempo para um projeto
     */
    public function start(Request $request): JsonResponse
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'session_name' => 'nullable|string|max:255',
            'description' => 'nullable|string'
        ]);

        // Verificar se já existe uma sessão ativa para este projeto
        $activeSession = TimeTracking::where('project_id', $request->project_id)
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if ($activeSession) {
            return response()->json([
                'success' => false,
                'message' => 'Já existe uma sessão ativa para este projeto'
            ], 400);
        }

        // Criar nova sessão de tracking
        $timeTracking = TimeTracking::create([
            'project_id' => $request->project_id,
            'user_id' => auth()->id(),
            'session_name' => $request->session_name,
            'description' => $request->description,
            'started_at' => now(),
            'status' => 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sessão de trabalho iniciada',
            'data' => [
                'id' => $timeTracking->id,
                'started_at' => $timeTracking->started_at->toISOString(),
                'session_name' => $timeTracking->session_name,
                'elapsed_time' => $timeTracking->formatted_elapsed_time
            ]
        ]);
    }

    /**
     * Pausar tracking de tempo
     */
    public function pause(Request $request): JsonResponse
    {
        $request->validate([
            'tracking_id' => 'required|exists:time_trackings,id'
        ]);

        $timeTracking = TimeTracking::where('id', $request->tracking_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$timeTracking) {
            return response()->json([
                'success' => false,
                'message' => 'Sessão não encontrada'
            ], 404);
        }

        if ($timeTracking->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Sessão não está ativa'
            ], 400);
        }

        $timeTracking->pause();

        return response()->json([
            'success' => true,
            'message' => 'Sessão pausada',
            'data' => [
                'id' => $timeTracking->id,
                'status' => $timeTracking->status,
                'elapsed_time' => $timeTracking->formatted_elapsed_time
            ]
        ]);
    }

    /**
     * Retomar tracking de tempo
     */
    public function resume(Request $request): JsonResponse
    {
        $request->validate([
            'tracking_id' => 'required|exists:time_trackings,id'
        ]);

        $timeTracking = TimeTracking::where('id', $request->tracking_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$timeTracking) {
            return response()->json([
                'success' => false,
                'message' => 'Sessão não encontrada'
            ], 404);
        }

        if ($timeTracking->status !== 'paused') {
            return response()->json([
                'success' => false,
                'message' => 'Sessão não está pausada'
            ], 400);
        }

        $timeTracking->resume();

        return response()->json([
            'success' => true,
            'message' => 'Sessão retomada',
            'data' => [
                'id' => $timeTracking->id,
                'status' => $timeTracking->status,
                'elapsed_time' => $timeTracking->formatted_elapsed_time
            ]
        ]);
    }

    /**
     * Parar tracking de tempo
     */
    public function stop(Request $request): JsonResponse
    {
        $request->validate([
            'tracking_id' => 'required|exists:time_trackings,id'
        ]);

        $timeTracking = TimeTracking::where('id', $request->tracking_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$timeTracking) {
            return response()->json([
                'success' => false,
                'message' => 'Sessão não encontrada'
            ], 404);
        }

        if (!in_array($timeTracking->status, ['active', 'paused'])) {
            return response()->json([
                'success' => false,
                'message' => 'Sessão já foi finalizada'
            ], 400);
        }

        $timeTracking->stop();

        // Atualizar tempo total gasto no projeto
        $project = $timeTracking->project;
        $totalTimeSpent = $project->timeTrackings()
            ->where('status', 'completed')
            ->sum('duration_minutes');
        
        $project->update(['time_spent' => $totalTimeSpent]);

        return response()->json([
            'success' => true,
            'message' => 'Sessão finalizada',
            'data' => [
                'id' => $timeTracking->id,
                'status' => $timeTracking->status,
                'duration_minutes' => $timeTracking->duration_minutes,
                'formatted_duration' => $timeTracking->formatted_elapsed_time,
                'total_project_time' => $totalTimeSpent
            ]
        ]);
    }

    /**
     * Obter status atual do tracking
     */
    public function status(Request $request): JsonResponse
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id'
        ]);

        $activeSession = TimeTracking::where('project_id', $request->project_id)
            ->where('user_id', auth()->id())
            ->whereIn('status', ['active', 'paused'])
            ->first();

        if (!$activeSession) {
            return response()->json([
                'success' => true,
                'data' => [
                    'has_active_session' => false
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'has_active_session' => true,
                'id' => $activeSession->id,
                'status' => $activeSession->status,
                'session_name' => $activeSession->session_name,
                'started_at' => $activeSession->started_at->toISOString(),
                'elapsed_time' => $activeSession->elapsed_time,
                'formatted_elapsed_time' => $activeSession->formatted_elapsed_time,
                'pause_periods' => $activeSession->pause_periods
            ]
        ]);
    }

    /**
     * Obter histórico de sessões de um projeto
     */
    public function history(Request $request): JsonResponse
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'limit' => 'nullable|integer|min:1|max:100'
        ]);

        $limit = $request->get('limit', 20);

        $sessions = TimeTracking::where('project_id', $request->project_id)
            ->where('user_id', auth()->id())
            ->orderBy('started_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'session_name' => $session->session_name,
                    'description' => $session->description,
                    'started_at' => $session->started_at->toISOString(),
                    'ended_at' => $session->ended_at?->toISOString(),
                    'duration_minutes' => $session->duration_minutes,
                    'formatted_duration' => $session->formatted_elapsed_time,
                    'status' => $session->status
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $sessions
        ]);
    }

    /**
     * Obter estatísticas de tempo para um projeto
     */
    public function stats(Request $request): JsonResponse
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id'
        ]);

        $project = Project::findOrFail($request->project_id);

        // Estatísticas gerais
        $totalSessions = $project->timeTrackings()
            ->where('user_id', auth()->id())
            ->count();

        $totalTimeSpent = $project->timeTrackings()
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->sum('duration_minutes');

        // Tempo hoje
        $todayTime = $project->timeTrackings()
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->today()
            ->sum('duration_minutes');

        // Tempo esta semana
        $weekTime = $project->timeTrackings()
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->thisWeek()
            ->sum('duration_minutes');

        // Sessão ativa atual
        $activeSession = $project->timeTrackings()
            ->where('user_id', auth()->id())
            ->whereIn('status', ['active', 'paused'])
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'total_sessions' => $totalSessions,
                'total_time_minutes' => $totalTimeSpent,
                'total_time_formatted' => $this->formatMinutes($totalTimeSpent),
                'today_time_minutes' => $todayTime,
                'today_time_formatted' => $this->formatMinutes($todayTime),
                'week_time_minutes' => $weekTime,
                'week_time_formatted' => $this->formatMinutes($weekTime),
                'active_session' => $activeSession ? [
                    'id' => $activeSession->id,
                    'status' => $activeSession->status,
                    'session_name' => $activeSession->session_name,
                    'started_at' => $activeSession->started_at->toISOString(),
                    'elapsed_time' => $activeSession->elapsed_time,
                    'formatted_elapsed_time' => $activeSession->formatted_elapsed_time
                ] : null
            ]
        ]);
    }

    /**
     * Obter todas as sessões ativas do usuário
     */
    public function activeSessions(): JsonResponse
    {
        $activeSessions = TimeTracking::where('user_id', auth()->id())
            ->whereIn('status', ['active', 'paused'])
            ->with('project:id,name')
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'project_id' => $session->project_id,
                    'project_name' => $session->project->name,
                    'session_name' => $session->session_name,
                    'description' => $session->description,
                    'started_at' => $session->started_at->toISOString(),
                    'status' => $session->status,
                    'elapsed_time' => $session->elapsed_time,
                    'formatted_elapsed_time' => $session->formatted_elapsed_time
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $activeSessions
        ]);
    }

    /**
     * Formatar minutos em formato legível
     */
    private function formatMinutes(int $minutes): string
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        
        if ($hours > 0) {
            return sprintf('%dh %02dm', $hours, $mins);
        }
        
        return sprintf('%dm', $mins);
    }
}