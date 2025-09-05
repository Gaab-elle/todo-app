<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::withCount('tasks')->orderBy('name')->get();
        $availableLocales = config('app.available_locales');
        $currentLocale = app()->getLocale();
        
        return view('projects.index', compact('projects', 'availableLocales', 'currentLocale'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $availableLocales = config('app.available_locales');
        $currentLocale = app()->getLocale();
        
        return view('projects.create', compact('availableLocales', 'currentLocale'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'icon' => 'nullable|string|max:50'
        ]);

        Project::create($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true], 201);
        }

        return redirect()->route('projects.index')->with('success', __('messages.project_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['tasks' => function($query) {
            $query->with(['subtasks', 'dependencies.dependsOnTask'])->orderBy('created_at', 'desc');
        }]);
        
        $availableLocales = config('app.available_locales');
        $currentLocale = app()->getLocale();
        
        return view('projects.show', compact('project', 'availableLocales', 'currentLocale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $availableLocales = config('app.available_locales');
        $currentLocale = app()->getLocale();
        
        return view('projects.edit', compact('project', 'availableLocales', 'currentLocale'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        $project->update($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('projects.index')->with('success', __('messages.project_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Check if project has tasks
        if ($project->tasks()->count() > 0) {
            return back()->with('error', __('messages.cannot_delete_project_with_tasks'));
        }

        $project->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('projects.index')->with('success', __('messages.project_deleted'));
    }

    /**
     * Toggle favorite status of the project.
     */
    public function toggleFavorite(Project $project)
    {
        try {
            $project->update(['is_favorite' => !$project->is_favorite]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'is_favorite' => $project->is_favorite,
                    'message' => $project->is_favorite ? __('messages.project_favorited') : __('messages.project_unfavorited')
                ]);
            }

            return back()->with('success', $project->is_favorite ? __('messages.project_favorited') : __('messages.project_unfavorited'));
        } catch (\Exception $e) {
            \Log::error('Error toggling favorite: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro interno do servidor'
                ], 500);
            }

            return back()->with('error', 'Erro ao atualizar favorito');
        }
    }
}
