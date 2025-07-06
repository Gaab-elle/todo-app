<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->get('filter', 'all');
        
        $query = Task::query()->orderBy('created_at', 'desc');
        
        switch ($filter) {
            case 'completed':
                $query->completed();
                break;
            case 'pending':
                $query->pending();
                break;
            case 'high':
                $query->byPriority('high');
                break;
            case 'medium':
                $query->byPriority('medium');
                break;
            case 'low':
                $query->byPriority('low');
                break;
        }
        
        $tasks = $query->get();
        
        $stats = [
            'total' => Task::count(),
            'completed' => Task::completed()->count(),
            'pending' => Task::pending()->count(),
            'high_priority' => Task::byPriority('high')->count(),
        ];
        
        return view('tasks.index', compact('tasks', 'filter', 'stats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date|after:today'
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa criada com sucesso!');
    }

    public function toggle(Task $task): RedirectResponse
    {
        $task->update(['completed' => !$task->completed]);
        
        $message = $task->completed 
            ? 'Tarefa marcada como concluída!' 
            : 'Tarefa marcada como pendente!';
            
        return redirect()->route('tasks.index')
            ->with('success', $message);
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();
        
        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa excluída com sucesso!');
    }
}