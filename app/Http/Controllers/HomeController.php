<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    /**
     * Display the home page with overview.
     */
    public function index()
    {
        $totalTasks = Task::count();
        $completedTasks = Task::completed()->count();
        $pendingTasks = Task::pending()->count();
        $highPriorityTasks = Task::byPriority('high')->count();
        
        // Tarefas urgentes (nova funcionalidade)
        $urgentTasks = Task::urgent()->count();
        
        // Próxima tarefa com prazo
        $nextTaskWithDueDate = Task::whereNotNull('due_date')
            ->where('completed', false)
            ->where('due_date', '>', now())
            ->orderBy('due_date', 'asc')
            ->first();
        
        $daysUntilNextTask = null;
        if ($nextTaskWithDueDate) {
            $daysUntilNextTask = now()->diffInDays($nextTaskWithDueDate->due_date, false);
        }
        
        // Tarefas para as tabs
        $upcomingTasks = Task::where('completed', false)
            ->where(function($query) {
                $query->whereNull('due_date')
                      ->orWhere('due_date', '>', now()->toDateString());
            })
            ->orderBy('due_date', 'asc')
            ->get();
        
        $overdueTasks = Task::where('completed', false)
            ->whereNotNull('due_date')
            ->where('due_date', '<', now()->toDateString())
            ->orderBy('due_date', 'asc')
            ->get();
        
        $completedTasksList = Task::completed()
            ->orderBy('updated_at', 'desc')
            ->get();
        
        // Projetos para as tabs
        $activeProjects = \App\Models\Project::withCount('tasks')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $archivedProjects = \App\Models\Project::withCount('tasks')
            ->where('is_active', false)
            ->orderBy('updated_at', 'desc')
            ->get();
        
        $favoriteProjects = \App\Models\Project::withCount('tasks')
            ->where('is_favorite', true)
            ->where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get();
        
        $recentTasks = Task::orderBy('created_at', 'desc')->limit(5)->get();
        
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;
        
        // Dados específicos para desenvolvimento
        $totalProjects = Project::count();
        $activeProjectsCount = Project::where('is_active', true)->count();
        $totalTimeSpent = Project::sum('time_spent'); // em minutos
        $totalTimeSpentHours = round($totalTimeSpent / 60, 1);
        
        // Projetos por tipo
        $projectsByType = Project::selectRaw('project_type, COUNT(*) as count')
            ->whereNotNull('project_type')
            ->groupBy('project_type')
            ->get();
        
        // Linguagens mais utilizadas
        $allLanguages = Project::whereNotNull('programming_languages')
            ->get()
            ->pluck('programming_languages')
            ->flatten()
            ->countBy()
            ->sortDesc()
            ->take(5);
        
        // Tecnologias mais utilizadas
        $allTechnologies = Project::whereNotNull('technologies_used')
            ->get()
            ->pluck('technologies_used')
            ->flatten()
            ->countBy()
            ->sortDesc()
            ->take(5);
        
        // Projetos por status
        $projectsByStatus = Project::selectRaw('development_status, COUNT(*) as count')
            ->groupBy('development_status')
            ->get();
        
        return view('home.index', [
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'pendingTasks' => $pendingTasks,
            'highPriorityTasks' => $highPriorityTasks,
            'urgentTasks' => $urgentTasks,
            'nextTaskWithDueDate' => $nextTaskWithDueDate,
            'daysUntilNextTask' => $daysUntilNextTask,
            'recentTasks' => $recentTasks,
            'upcomingTasks' => $upcomingTasks,
            'overdueTasks' => $overdueTasks,
            'completedTasksList' => $completedTasksList,
            'activeProjects' => $activeProjects,
            'archivedProjects' => $archivedProjects,
            'favoriteProjects' => $favoriteProjects,
            'completionRate' => $completionRate,
            'currentLocale' => App::getLocale(),
            'availableLocales' => config('app.available_locales'),
            // Dados específicos para desenvolvimento
            'totalProjects' => $totalProjects,
            'activeProjectsCount' => $activeProjectsCount,
            'totalTimeSpentHours' => $totalTimeSpentHours,
            'projectsByType' => $projectsByType,
            'allLanguages' => $allLanguages,
            'allTechnologies' => $allTechnologies,
            'projectsByStatus' => $projectsByStatus
        ]);
    }

    /**
     * Get the most urgent task for the bottom sheet
     */
    public function getMostUrgentTask()
    {
        $mostUrgentTask = Task::urgent()
            ->with('project')
            ->orderBy('due_date', 'asc')
            ->orderBy('priority', 'desc')
            ->first();

        if ($mostUrgentTask) {
            return response()->json([
                'task' => [
                    'id' => $mostUrgentTask->id,
                    'title' => $mostUrgentTask->title,
                    'description' => $mostUrgentTask->description,
                    'priority' => $mostUrgentTask->priority,
                    'status' => $mostUrgentTask->status,
                    'due_date' => $mostUrgentTask->due_date?->toISOString(),
                    'urgency_level' => $mostUrgentTask->urgency_level,
                    'project' => $mostUrgentTask->project ? [
                        'id' => $mostUrgentTask->project->id,
                        'name' => $mostUrgentTask->project->name
                    ] : null
                ]
            ]);
        }

        return response()->json(['task' => null]);
    }

    /**
     * Global search functionality
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            return redirect()->route('home.index');
        }

        // Buscar em tarefas
        $tasks = Task::where(function($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%");
        })->with('project')->orderBy('created_at', 'desc')->get();

        // Buscar em projetos
        $projects = \App\Models\Project::where(function($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%");
        })->withCount('tasks')->orderBy('created_at', 'desc')->get();

        return view('search.results', [
            'query' => $query,
            'tasks' => $tasks,
            'projects' => $projects,
            'currentLocale' => App::getLocale(),
            'availableLocales' => config('app.available_locales')
        ]);
    }
}