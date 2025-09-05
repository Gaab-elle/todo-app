<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0'
        ]);

        // Set order if not provided
        if (!isset($validated['order'])) {
            $maxOrder = Subtask::where('task_id', $validated['task_id'])->max('order') ?? 0;
            $validated['order'] = $maxOrder + 1;
        }

        $subtask = Subtask::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'subtask' => $subtask->load('task')
            ], 201);
        }

        return back()->with('success', __('messages.subtask_created'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subtask $subtask)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0'
        ]);

        $subtask->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'subtask' => $subtask
            ]);
        }

        return back()->with('success', __('messages.subtask_updated'));
    }

    /**
     * Toggle subtask completion status.
     */
    public function toggle(Subtask $subtask)
    {
        $subtask->update(['completed' => !$subtask->completed]);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'subtask' => $subtask,
                'completion_percentage' => $subtask->task->completion_percentage
            ]);
        }

        return back()->with('success', __('messages.subtask_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subtask $subtask)
    {
        $subtask->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'completion_percentage' => $subtask->task->fresh()->completion_percentage
            ]);
        }

        return back()->with('success', __('messages.subtask_deleted'));
    }
}
