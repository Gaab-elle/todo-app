<div class="task-card bg-gray-600 rounded-xl border border-gray-500 p-4 shadow-lg hover:shadow-xl transition-all duration-300 cursor-move" 
     data-task-id="{{ $task->id }}" 
     draggable="true">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-3">
                <h4 class="text-lg font-semibold {{ $task->completed ? 'line-through text-gray-400' : 'text-white' }} group-hover:text-blue-100 transition-colors duration-300">
                    {{ $task->title }}
                </h4>
                
                <!-- Project Badge -->
                @if($task->project)
                    <span class="px-2 py-1 text-xs font-semibold rounded-full border" style="background-color: {{ $task->project->color }}20; color: {{ $task->project->color }}; border-color: {{ $task->project->color }}40;">
                        {{ $task->project->name }}
                    </span>
                @endif
                
                <!-- Priority Badge -->
                <span class="px-2 py-1 text-xs font-semibold rounded-full text-white shadow-refined
                    @if($task->priority === 'high') bg-gradient-danger shadow-glow-red
                    @elseif($task->priority === 'medium') bg-gradient-warning shadow-glow-yellow
                    @else bg-gradient-success shadow-glow-green
                    @endif">
                    {{ __("messages.{$task->priority}") }}
                </span>
            </div>
            
            @if($task->description)
                <p class="text-gray-300 mb-3 text-sm leading-relaxed {{ $task->completed ? 'line-through' : '' }}">
                    {{ Str::limit($task->description, 100) }}
                </p>
            @endif
            
            @if($task->tags && count($task->tags) > 0)
                <div class="flex flex-wrap gap-1 mb-3">
                    @foreach($task->tags as $tag)
                        <span class="px-2 py-1 text-xs font-medium bg-blue-600/20 text-blue-300 rounded-full border border-blue-500/30">
                            #{{ $tag }}
                        </span>
                    @endforeach
                </div>
            @endif
            
            <!-- Subtasks Section -->
            @if($task->subtasks->count() > 0)
                <div class="mb-3">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-gray-400">{{ __('messages.subtasks') }} ({{ $task->subtasks->where('completed', true)->count() }}/{{ $task->subtasks->count() }})</span>
                        <span class="text-xs text-gray-400">{{ round(($task->subtasks->where('completed', true)->count() / $task->subtasks->count()) * 100) }}%</span>
                    </div>
                    <div class="w-full bg-gray-500 rounded-full h-1.5">
                        <div class="bg-green-500 h-1.5 rounded-full transition-all duration-300" 
                             style="width: {{ ($task->subtasks->where('completed', true)->count() / $task->subtasks->count()) * 100 }}%"></div>
                    </div>
                </div>
            @endif
            
            <!-- Task Dates -->
            <div class="flex items-center space-x-3 text-xs text-gray-400">
                <div class="flex items-center space-x-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $task->created_at->format('d/m/Y') }}</span>
                </div>
                @if($task->due_date)
                    <div class="flex items-center space-x-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}</span>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-col space-y-1 ml-3">
            @if(!$task->completed)
                <form action="{{ route('tasks.update', $task) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="completed" value="1">
                    <button type="submit" 
                            class="px-3 py-1 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white text-xs font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2 focus:ring-offset-gray-600 hover:scale-105 transform shadow-lg">
                        {{ __('messages.mark_completed') }}
                    </button>
                </form>
            @endif
            
            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="delete-form inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-3 py-1 bg-gradient-to-r from-pink-500 to-red-500 hover:from-pink-600 hover:to-red-600 text-white text-xs font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:ring-offset-2 focus:ring-offset-gray-600 hover:scale-105 transform shadow-lg">
                    {{ __('messages.delete_task') }}
                </button>
            </form>
        </div>
    </div>
</div>
