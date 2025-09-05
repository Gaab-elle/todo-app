@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 light:bg-gradient-to-br light:from-gray-100 light:via-gray-200 light:to-gray-300 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Navigation -->
        <nav class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home.index') }}" class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>{{ __('messages.home') }}</span>
                    </a>
                    <a href="{{ route('tasks.index') }}" class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <span>{{ __('messages.my_tasks') }}</span>
                    </a>
                    <a href="{{ route('projects.index') }}" class="flex items-center space-x-2 text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span>{{ __('messages.projects') }}</span>
                    </a>
                    <a href="{{ route('tasks.kanban') }}" class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z"></path>
                        </svg>
                        <span>{{ __('messages.kanban_board') }}</span>
                    </a>
                    <a href="{{ route('stats.index') }}" class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span>{{ __('messages.statistics') }}</span>
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-400">{{ __('messages.theme') }}:</span>
                        <button class="theme-toggle bg-gray-700 hover:bg-gray-600 p-2 rounded-lg transition-all duration-200" title="{{ __('messages.toggle_theme') }}">
                            <svg class="w-5 h-5 text-white theme-icon-dark" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                            <svg class="w-5 h-5 text-white theme-icon-light hidden" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-400">{{ __('messages.language') }}:</span>
                        @foreach($availableLocales as $locale)
                            <a href="{{ route('locale.switch', $locale) }}" class="px-3 py-1 text-sm rounded {{ $currentLocale === $locale ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                {{ strtoupper($locale) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </nav>

        <!-- Project Header -->
        <div class="bg-gray-700 rounded-2xl border border-gray-600 p-8 mb-8 shadow-lg animate-slide-up">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 rounded-xl" style="background-color: {{ $project->color }}20; border: 2px solid {{ $project->color }}">
                        @if($project->icon)
                            <span class="text-2xl">{{ $project->icon }}</span>
                        @else
                            <svg class="w-8 h-8" style="color: {{ $project->color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2">{{ $project->name }}</h1>
                        <p class="text-gray-300 text-lg">{{ $project->description }}</p>
                        <div class="flex items-center space-x-4 mt-2">
                            <span class="text-sm text-gray-400">{{ $project->tasks->count() }} {{ __('messages.tasks') }}</span>
                            <span class="text-sm text-gray-400">{{ __('messages.created') }}: {{ $project->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        {{ __('messages.edit') }}
                    </a>
                    <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        {{ __('messages.back') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Tasks Section -->
        <div class="bg-gray-700 rounded-2xl border border-gray-600 p-8 shadow-lg animate-slide-up" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white">{{ __('messages.project_tasks') }}</h2>
                <a href="{{ route('tasks.index') }}?project={{ $project->id }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    {{ __('messages.add_task') }}
                </a>
            </div>

            @if($project->tasks->count() > 0)
                <div class="grid gap-4">
                    @foreach($project->tasks as $task)
                        <div class="bg-gray-800 rounded-xl border border-gray-600 p-6 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="text-lg font-semibold text-white">{{ $task->title }}</h3>
                                        @if($task->priority)
                                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                                @if($task->priority === 'high') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @endif">
                                                {{ __('messages.' . $task->priority) }}
                                            </span>
                                        @endif
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            @if($task->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                            @endif">
                                            {{ __('messages.' . $task->status) }}
                                        </span>
                                    </div>
                                    
                                    @if($task->description)
                                        <p class="text-gray-300 mb-3">{{ $task->description }}</p>
                                    @endif

                                    @if($task->tags && count($task->tags) > 0)
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            @foreach($task->tags as $tag)
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs rounded-full">
                                                    {{ $tag }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($task->due_date)
                                        <p class="text-sm text-gray-400 mb-3">
                                            {{ __('messages.due_date') }}: {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                        </p>
                                    @endif

                                    @if($task->subtasks->count() > 0)
                                        <div class="mt-3">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-sm text-gray-400">{{ __('messages.subtasks') }}</span>
                                                <span class="text-sm text-gray-400">
                                                    {{ $task->subtasks->where('completed', true)->count() }}/{{ $task->subtasks->count() }}
                                                </span>
                                            </div>
                                            <div class="w-full bg-gray-600 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $task->subtasks->count() > 0 ? ($task->subtasks->where('completed', true)->count() / $task->subtasks->count()) * 100 : 0 }}%"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex items-center space-x-2 ml-4">
                                    <a href="{{ route('tasks.index') }}?task={{ $task->id }}" class="p-2 text-blue-400 hover:text-blue-300 transition-colors duration-200" title="{{ __('messages.view_task') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-20 w-20 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-300 mb-2">{{ __('messages.no_tasks_in_project') }}</h3>
                    <p class="text-gray-400 mb-6">{{ __('messages.no_tasks_in_project_description') }}</p>
                    <a href="{{ route('tasks.index') }}?project={{ $project->id }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2 focus:ring-offset-transparent hover:scale-105 transform">
                        {{ __('messages.create_first_task') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
