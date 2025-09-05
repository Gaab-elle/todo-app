<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $tasks = Task::with(['project', 'subtasks', 'dependencies.dependsOnTask'])
            ->search($search)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $projects = \App\Models\Project::active()->orderBy('name')->get();
        $availableLocales = config('app.available_locales');
        $currentLocale = app()->getLocale();
        
        return view('tasks.index', compact('tasks', 'projects', 'availableLocales', 'currentLocale', 'search'));
    }

    public function kanban(Request $request)
    {
        $search = $request->get('search');
        
        $tasks = Task::search($search)->orderBy('created_at', 'desc')->get();
        
        // Group tasks by status for Kanban view
        $tasksByStatus = [
            'pending' => Task::search($search)->byStatus('pending')->orderBy('created_at', 'desc')->get(),
            'in_progress' => Task::search($search)->byStatus('in_progress')->orderBy('created_at', 'desc')->get(),
            'review' => Task::search($search)->byStatus('review')->orderBy('created_at', 'desc')->get(),
            'completed' => Task::search($search)->byStatus('completed')->orderBy('created_at', 'desc')->get(),
        ];
        
        return view('tasks.kanban', [
            'tasks' => $tasks,
            'tasksByStatus' => $tasksByStatus,
            'currentLocale' => App::getLocale(),
            'search' => $search,
            'availableLocales' => config('app.available_locales')
        ]);
    }

    /**
     * Display the professional tasks interface.
     */
    public function professional()
    {
        $tasks = Task::latest()->get();
        
        $availableLocales = config('app.available_locales');
        $currentLocale = app()->getLocale();
        
        return view('tasks.professional', compact('tasks', 'availableLocales', 'currentLocale'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'status' => 'nullable|in:pending,in_progress,review,completed',
            'tags' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id'
        ]);

        // Process tags - convert comma-separated string to array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = [];
        }

        $task = Task::create($validated);

        if ($request->expectsJson()) {
            return response()->json($task, 201);
        }

        return redirect()->route('tasks.index')
            ->with('success', __('messages.task_created'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date'
        ]);

        $task->update($validated);

        if ($request->expectsJson()) {
            return response()->json($task);
        }

        return redirect()->route('tasks.index')
            ->with('success', __('messages.task_updated'));
    }

    /**
     * Toggle the completion status of the task.
     */
    public function toggle(Task $task)
    {
        $task->update([
            'completed' => !$task->completed
        ]);

        if (request()->expectsJson()) {
            return response()->json($task);
        }

        $message = $task->completed ? __('messages.task_completed') : __('messages.task_pending');
        
        return redirect()->route('tasks.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => __('messages.task_deleted')]);
        }

        return redirect()->route('tasks.index')
            ->with('success', __('messages.task_deleted'));
    }

    /**
     * Update task status via drag and drop.
     */
    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,review,completed'
        ]);

        $task->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.task_status_updated'),
                'task' => $task
            ]);
        }

        return redirect()->route('tasks.index')
            ->with('success', __('messages.task_status_updated'));
    }
}