<?php

namespace App\Http\Controllers;

use App\Models\Task;
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
        $recentTasks = Task::orderBy('created_at', 'desc')->limit(5)->get();
        
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;
        
        return view('home.index', [
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'pendingTasks' => $pendingTasks,
            'highPriorityTasks' => $highPriorityTasks,
            'recentTasks' => $recentTasks,
            'completionRate' => $completionRate,
            'currentLocale' => App::getLocale(),
            'availableLocales' => config('app.available_locales')
        ]);
    }
}