<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    /**
     * Display the statistics page.
     */
    public function index()
    {
        // Basic statistics
        $totalTasks = Task::count();
        $completedTasks = Task::completed()->count();
        $pendingTasks = Task::pending()->count();
        
        // Priority breakdown
        $priorityStats = Task::select('priority', DB::raw('count(*) as count'))
            ->groupBy('priority')
            ->get()
            ->pluck('count', 'priority');
        
        // Completion rate
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;
        
        // Tasks created by month (last 6 months)
        $monthlyStats = Task::select(
                DB::raw('strftime("%Y-%m", created_at) as month'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Overdue tasks
        $overdueTasks = Task::where('due_date', '<', now())
            ->where('completed', false)
            ->count();
        
        // Average completion time (in days)
        $avgCompletionTime = Task::completed()
            ->whereNotNull('created_at')
            ->selectRaw('AVG((julianday(updated_at) - julianday(created_at))) as avg_days')
            ->value('avg_days');
        
        return view('stats.index', [
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'pendingTasks' => $pendingTasks,
            'priorityStats' => $priorityStats,
            'completionRate' => $completionRate,
            'monthlyStats' => $monthlyStats,
            'overdueTasks' => $overdueTasks,
            'avgCompletionTime' => $avgCompletionTime ? round($avgCompletionTime, 1) : 0,
            'currentLocale' => App::getLocale(),
            'availableLocales' => config('app.available_locales')
        ]);
    }
}