@extends('layouts.app')

@section('title', __('messages.app_title'))

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in font-poppins">
    <!-- Navigation -->
    <nav class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <a href="{{ route('home.index') }}" 
                   class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>{{ __('messages.home') }}</span>
                </a>
                <a href="{{ route('tasks.index') }}" 
                   class="flex items-center space-x-2 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span>{{ __('messages.tasks') }}</span>
                </a>
                <a href="{{ route('projects.index') }}" 
                   class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>{{ __('messages.projects') }}</span>
                </a>
                <a href="{{ route('tasks.kanban') }}" 
                   class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z"></path>
                    </svg>
                    <span>{{ __('messages.kanban_board') }}</span>
                </a>
                <a href="{{ route('stats.index') }}" 
                   class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>{{ __('messages.statistics') }}</span>
                </a>
            </div>
            
            <!-- Theme Toggle and Language Switcher -->
            <div class="flex items-center space-x-6">
                <!-- Theme Toggle -->
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-400">{{ __('messages.theme') }}:</span>
                    <button class="theme-toggle bg-gray-700 hover:bg-gray-600 p-2 rounded-lg transition-all duration-200" title="{{ __('messages.toggle_theme') }}">
                        <svg class="w-5 h-5 text-white theme-icon-dark" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" clip-rule="evenodd"></path>
                        </svg>
                        <svg class="w-5 h-5 text-white theme-icon-light hidden" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Language Switcher -->
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-400">{{ __('messages.language') }}:</span>
                    @foreach($availableLocales as $locale)
                        <a href="{{ route('locale.switch', $locale) }}" 
                           class="px-3 py-1 text-sm rounded {{ $currentLocale === $locale ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                            {{ strtoupper($locale) }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="mb-8 animate-slide-up" style="animation-delay: 0.1s;">
        <h1 class="text-5xl font-bold dark:bg-gradient-to-r dark:from-white dark:via-blue-100 dark:to-purple-200 light:bg-gradient-to-r light:from-gray-800 light:via-gray-600 light:to-gray-700 bg-clip-text text-transparent mb-4 animate-float">{{ __('messages.my_tasks') }}</h1>
        <p class="dark:text-gray-300 light:text-gray-600 text-lg font-medium">{{ __('messages.manage_your_tasks') }}</p>
    </div>

    <!-- Search Bar -->
    <div class="bg-gray-700 rounded-2xl border border-gray-600 p-6 mb-8 shadow-lg animate-slide-up" style="animation-delay: 0.15s;">
        <form method="GET" action="{{ route('tasks.index') }}" class="flex items-center space-x-4">
            <div class="flex-1 relative">
                <input type="text" 
                       name="search" 
                       value="{{ $search ?? '' }}"
                       placeholder="{{ __('messages.search_placeholder') }}"
                       class="w-full px-4 py-3 pl-12 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30">
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2 focus:ring-offset-transparent hover:scale-105 transform">
                {{ __('messages.search') }}
            </button>
            @if(!empty($search))
                <a href="{{ route('tasks.index') }}" 
                   class="px-4 py-3 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500/50 focus:ring-offset-2 focus:ring-offset-transparent hover:scale-105 transform">
                    {{ __('messages.clear_search') }}
                </a>
            @endif
        </form>
        
        @if(!empty($search))
            <div class="mt-4 text-sm text-gray-400">
                {{ __('messages.search_results') }}: "{{ $search }}" ({{ $tasks->count() }} {{ $tasks->count() === 1 ? 'resultado' : 'resultados' }})
            </div>
        @endif
    </div>

    <!-- Tasks List with Drag and Drop -->
    <div id="columns" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Pending Column -->
        <div class="column bg-gray-700 rounded-2xl border border-gray-600 p-6 shadow-lg" data-status="pending">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white flex items-center space-x-2">
                    <span>⏳</span>
                    <span>{{ __('messages.pending') }}</span>
                </h3>
                <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-sm font-semibold border border-yellow-500/30">
                    {{ $tasks->where('status', 'pending')->count() }}
                </span>
            </div>
            <div class="space-y-4 min-h-[200px]">
                @foreach($tasks->where('status', 'pending') as $task)
                    @include('tasks.partials.task-card', ['task' => $task])
                @endforeach
            </div>
        </div>

        <!-- In Progress Column -->
        <div class="column bg-gray-700 rounded-2xl border border-gray-600 p-6 shadow-lg" data-status="in_progress">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white flex items-center space-x-2">
                    <span>🔄</span>
                    <span>{{ __('messages.in_progress') }}</span>
                </h3>
                <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm font-semibold border border-blue-500/30">
                    {{ $tasks->where('status', 'in_progress')->count() }}
                </span>
            </div>
            <div class="space-y-4 min-h-[200px]">
                @foreach($tasks->where('status', 'in_progress') as $task)
                    @include('tasks.partials.task-card', ['task' => $task])
                @endforeach
            </div>
        </div>

        <!-- Review Column -->
        <div class="column bg-gray-700 rounded-2xl border border-gray-600 p-6 shadow-lg" data-status="review">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white flex items-center space-x-2">
                    <span>👀</span>
                    <span>{{ __('messages.review') }}</span>
                </h3>
                <span class="bg-orange-500/20 text-orange-400 px-3 py-1 rounded-full text-sm font-semibold border border-orange-500/30">
                    {{ $tasks->where('status', 'review')->count() }}
                </span>
            </div>
            <div class="space-y-4 min-h-[200px]">
                @foreach($tasks->where('status', 'review') as $task)
                    @include('tasks.partials.task-card', ['task' => $task])
                @endforeach
            </div>
        </div>

        <!-- Completed Column -->
        <div class="column bg-gray-700 rounded-2xl border border-gray-600 p-6 shadow-lg" data-status="completed">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white flex items-center space-x-2">
                    <span>✅</span>
                    <span>{{ __('messages.completed') }}</span>
                </h3>
                <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm font-semibold border border-green-500/30">
                    {{ $tasks->where('status', 'completed')->count() }}
                </span>
            </div>
            <div class="space-y-4 min-h-[200px]">
                @foreach($tasks->where('status', 'completed') as $task)
                    @include('tasks.partials/task-card', ['task' => $task])
                @endforeach
            </div>
        </div>
    </div>

    @if($tasks->isEmpty())
        <div class="text-center py-12">
            <div class="w-24 h-24 mx-auto mb-6 text-gray-400">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-300 mb-2">{{ __('messages.no_tasks_found') }}</h3>
            <p class="text-gray-400 mb-6">{{ __('messages.no_tasks_description') }}</p>
            <button onclick="createTaskModal()" class="px-6 py-3 bg-gradient-primary hover:shadow-glow text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2 focus:ring-offset-transparent hover:scale-105 transform">
                {{ __('messages.create_first_task') }}
            </button>
        </div>
    @endif

    <!-- Original Tasks List (Hidden) -->
    <div class="space-y-6 hidden">
        @forelse($tasks as $task)
            <div class="bg-gray-700 rounded-2xl border border-gray-600 p-6 shadow-lg hover:shadow-xl transition-all duration-400 animate-slide-up {{ $task->completed ? 'border-l-4 border-l-green-400' : 'border-l-4 border-l-blue-400' }} group hover:scale-[1.02] transform">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-4">
                            <h3 class="text-xl font-semibold {{ $task->completed ? 'line-through text-gray-400' : 'text-white' }} group-hover:text-blue-100 transition-colors duration-300">
                                {{ $task->title }}
                            </h3>
                            
                            <!-- Project Badge -->
                            @if($task->project)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full border" style="background-color: {{ $task->project->color }}20; color: {{ $task->project->color }}; border-color: {{ $task->project->color }}40;">
                                    {{ $task->project->name }}
                                </span>
                            @endif
                            
                            <!-- Priority Badge -->
                            <span class="px-3 py-1 text-xs font-semibold rounded-full text-white shadow-refined
                                @if($task->priority === 'high') bg-gradient-danger shadow-glow-red
                                @elseif($task->priority === 'medium') bg-gradient-warning shadow-glow-yellow
                                @else bg-gradient-success shadow-glow-green
                                @endif">
                                {{ __("messages.{$task->priority}") }}
                            </span>
                            
                            @if($task->completed)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gradient-success text-white shadow-glow-green">
                                    {{ __('messages.completed') }}
                                </span>
                            @endif
                        </div>
                        
                        @if($task->description)
                            <p class="text-gray-300 mb-4 leading-relaxed {{ $task->completed ? 'line-through' : '' }}">
                                {{ $task->description }}
                            </p>
                        @endif
                        
                        @if($task->tags && count($task->tags) > 0)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($task->tags as $tag)
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-600/20 text-blue-300 rounded-full border border-blue-500/30">
                                        #{{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                        
                        <!-- Subtasks Section -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-semibold text-gray-300 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                    <span>{{ __('messages.subtasks') }}</span>
                                    @if($task->subtasks->count() > 0)
                                        <span class="text-xs text-gray-400">({{ $task->subtasks->where('completed', true)->count() }}/{{ $task->subtasks->count() }})</span>
                                    @endif
                                </h4>
                                <button onclick="toggleSubtasks({{ $task->id }})" class="text-xs text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                    {{ __('messages.add_subtask') }}
                                </button>
                            </div>
                            
                            <!-- Progress Bar -->
                            @if($task->subtasks->count() > 0)
                                <div class="mb-3">
                                    <div class="flex items-center justify-between text-xs text-gray-400 mb-1">
                                        <span>{{ __('messages.completion_percentage') }}</span>
                                        <span>{{ $task->completion_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-600 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-blue-500 to-green-500 h-2 rounded-full transition-all duration-300" 
                                             style="width: {{ $task->completion_percentage }}%"></div>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Subtasks List -->
                            <div id="subtasks-{{ $task->id }}" class="space-y-2">
                                @forelse($task->subtasks as $subtask)
                                    <div class="flex items-center space-x-3 p-2 bg-gray-800/50 rounded-lg border border-gray-600/30">
                                        <button onclick="toggleSubtask({{ $subtask->id }})" 
                                                class="flex-shrink-0 w-5 h-5 rounded border-2 transition-all duration-200 {{ $subtask->completed ? 'bg-green-500 border-green-500' : 'border-gray-400 hover:border-green-400' }}">
                                            @if($subtask->completed)
                                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </button>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm {{ $subtask->completed ? 'line-through text-gray-400' : 'text-gray-200' }}">
                                                {{ $subtask->title }}
                                            </p>
                                            @if($subtask->description)
                                                <p class="text-xs text-gray-500 mt-1">{{ $subtask->description }}</p>
                                            @endif
                                        </div>
                                        <button onclick="deleteSubtask({{ $subtask->id }})" 
                                                class="flex-shrink-0 text-gray-400 hover:text-red-400 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 italic">{{ __('messages.no_subtasks') }}</p>
                                @endforelse
                            </div>
                            
                            <!-- Add Subtask Form (Hidden by default) -->
                            <div id="add-subtask-{{ $task->id }}" class="hidden mt-3 p-3 bg-gray-800/30 rounded-lg border border-gray-600/30">
                                <form onsubmit="addSubtask(event, {{ $task->id }})">
                                    <div class="space-y-3">
                                        <input type="text" 
                                               name="title" 
                                               required
                                               class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50"
                                               placeholder="{{ __('messages.add_subtask_placeholder') }}">
                                        <textarea name="description" 
                                                  rows="2"
                                                  class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 resize-none"
                                                  placeholder="{{ __('messages.subtask_description_placeholder') }}"></textarea>
                                        <div class="flex justify-end space-x-2">
                                            <button type="button" 
                                                    onclick="toggleSubtasks({{ $task->id }})"
                                                    class="px-3 py-1 text-xs bg-gray-600 hover:bg-gray-500 text-white rounded transition-colors duration-200">
                                                {{ __('messages.cancel') }}
                                            </button>
                                            <button type="submit" 
                                                    class="px-3 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition-colors duration-200">
                                                {{ __('messages.add_subtask') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-6 text-sm text-gray-400">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ __('messages.created') }}: {{ $task->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($task->due_date)
                                <div class="flex items-center space-x-2 {{ $task->due_date < now() && !$task->completed ? 'text-red-400' : '' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ __('messages.due_date') }}: {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex items-center space-x-3 ml-6">
                        <!-- Toggle Complete -->
                        <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-transparent
                                    {{ $task->completed ? 'bg-gradient-warning hover:shadow-glow-yellow text-white focus:ring-yellow-500/50' : 'bg-gradient-success hover:shadow-glow-green text-white focus:ring-green-500/50' }}">
                                {{ $task->completed ? __('messages.mark_pending') : __('messages.mark_complete') }}
                            </button>
                        </form>
                        
                        <!-- Delete -->
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-4 py-2 text-sm font-semibold bg-gradient-danger hover:shadow-glow-red text-white rounded-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:ring-offset-2 focus:ring-offset-transparent">
                                {{ __('messages.delete_task') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 animate-fade-in">
                <div class="bg-gray-700 rounded-2xl border border-gray-600 p-12 shadow-lg">
                    <div class="text-gray-600 text-lg mb-6">
                        <svg class="mx-auto h-20 w-20 mb-6 animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('messages.no_tasks') }}</h3>
                    <p class="text-gray-700 text-lg">{{ __('messages.no_tasks_description') }}</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<script>
// Subtasks Management
function toggleSubtasks(taskId) {
    const form = document.getElementById(`add-subtask-${taskId}`);
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        form.querySelector('input[name="title"]').focus();
    } else {
        form.classList.add('hidden');
        form.reset();
    }
}

function addSubtask(event, taskId) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const data = {
        task_id: taskId,
        title: formData.get('title'),
        description: formData.get('description') || null
    };
    
    fetch('/subtasks', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload to show new subtask
        }
    })
    .catch(error => {
        console.error('Error adding subtask:', error);
    });
}

function toggleSubtask(subtaskId) {
    fetch(`/subtasks/${subtaskId}/toggle`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload to update progress
        }
    })
    .catch(error => {
        console.error('Error toggling subtask:', error);
    });
}

function deleteSubtask(subtaskId) {
    if (!confirm('{{ __("messages.confirm_delete") }}')) {
        return;
    }
    
    fetch(`/subtasks/${subtaskId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload to update progress
        }
    })
    .catch(error => {
        console.error('Error deleting subtask:', error);
    });
}
</script>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('{{ __("messages.confirm_delete") }}')) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endpush

@push('styles')
<style>
/* Drag and Drop Styles */
.column {
    transition: all 0.3s ease;
}

.column.over {
    background: rgba(59, 130, 246, 0.1);
    border-color: rgba(59, 130, 246, 0.5);
    transform: scale(1.02);
}

.task-card {
    transition: all 0.3s ease;
    user-select: none;
}

.task-card.dragElem {
    opacity: 0.5;
    transform: rotate(5deg);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

.task-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

/* Light mode adjustments */
.light .column {
    background: rgba(209, 213, 219, 0.8);
    border-color: rgba(156, 163, 175, 0.5);
}

.light .column.over {
    background: rgba(59, 130, 246, 0.1);
    border-color: rgba(59, 130, 246, 0.3);
}

.light .task-card {
    background: rgba(156, 163, 175, 0.8);
    border-color: rgba(107, 114, 128, 0.5);
}
</style>
@endpush

@push('scripts')
<script>
var dragSrcEl = null;

function handleDragStart(e) {
  // Target (this) element is the source node.
  dragSrcEl = this;

  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text/html', this.outerHTML);

  this.classList.add('dragElem');
}

function handleDragOver(e) {
  if (e.preventDefault) {
    e.preventDefault(); // Necessary. Allows us to drop.
  }
  this.classList.add('over');

  e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

  return false;
}

function handleDragEnter(e) {
  // this / e.target is the current hover target.
}

function handleDragLeave(e) {
  this.classList.remove('over');  // this / e.target is previous target element.
}

function handleDrop(e) {
  // this/e.target is current target element.

  if (e.stopPropagation) {
    e.stopPropagation(); // Stops some browsers from redirecting.
  }

  // Don't do anything if dropping the same column we're dragging.
  if (dragSrcEl != this) {
    // Get the task ID from the dragged element
    const draggedTaskId = dragSrcEl.getAttribute('data-task-id');
    const newStatus = this.getAttribute('data-status');
    
    if (draggedTaskId && newStatus) {
      // Update task status via AJAX
      updateTaskStatus(draggedTaskId, newStatus);
    }
    
    // Set the source column's HTML to the HTML of the column we dropped on.
    this.parentNode.removeChild(dragSrcEl);
    var dropHTML = e.dataTransfer.getData('text/html');
    this.insertAdjacentHTML('beforebegin', dropHTML);
    var dropElem = this.previousSibling;
    addDnDHandlers(dropElem);
  }
  this.classList.remove('over');
  return false;
}

function handleDragEnd(e) {
  // this/e.target is the source node.
  this.classList.remove('over');
  this.classList.remove('dragElem');
}

function addDnDHandlers(elem) {
  elem.addEventListener('dragstart', handleDragStart, false);
  elem.addEventListener('dragenter', handleDragEnter, false)
  elem.addEventListener('dragover', handleDragOver, false);
  elem.addEventListener('dragleave', handleDragLeave, false);
  elem.addEventListener('drop', handleDrop, false);
  elem.addEventListener('dragend', handleDragEnd, false);
}

function updateTaskStatus(taskId, newStatus) {
    fetch(`/tasks/${taskId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            status: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update column counts
            updateColumnCounts();
            showNotification(data.message || 'Status atualizado com sucesso!', 'success');
        } else {
            showNotification(data.message || 'Erro ao atualizar status', 'error');
            // Reload page to reset positions
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error updating task status:', error);
        showNotification('Erro de conexão. Tente novamente.', 'error');
        // Reload page to reset positions
        location.reload();
    });
}

function updateColumnCounts() {
    const columns = document.querySelectorAll('.column');
    columns.forEach(column => {
        const taskCards = column.querySelectorAll('.task-card');
        const count = taskCards.length;
        const countElement = column.querySelector('span[class*="bg-"]');
        if (countElement) {
            countElement.textContent = count;
        }
    });
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Initialize drag and drop when page loads
document.addEventListener('DOMContentLoaded', function() {
    var cols = document.querySelectorAll('#columns .column');
    [].forEach.call(cols, addDnDHandlers);
    
    // Add handlers to existing task cards
    var taskCards = document.querySelectorAll('.task-card');
    [].forEach.call(taskCards, addDnDHandlers);
});
</script>
@endpush
