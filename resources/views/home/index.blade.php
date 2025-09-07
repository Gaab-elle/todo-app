@extends('layouts.app')

@section('title', __('messages.app_title'))

@section('content')
<div class="min-h-screen">
    <!-- Top Bar -->
    <div class="bg-white/20 dark:bg-gray-900/80 dark:rounded-lg border-b border-gray-200/20 dark:border-gray-700/50 px-6 py-4 mb-6 dark:shadow-lg dark:backdrop-blur-sm">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ date('l, j \d\e F') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-300 mt-1">
                    E aí! Bora codar mais um dia de projetos?
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="p-6">
        <!-- Developer Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Projects -->
            <div class="bg-white/20 dark:bg-gray-900/80 dark:rounded-lg border border-gray-200/20 dark:border-gray-700/50 shadow-sm dark:shadow-lg dark:backdrop-blur-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.projects') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalProjects }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Projects -->
            <div class="bg-white/20 dark:bg-gray-900/80 dark:rounded-lg border border-gray-200/20 dark:border-gray-700/50 shadow-sm dark:shadow-lg dark:backdrop-blur-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.active') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $activeProjectsCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Time Spent -->
            <div class="bg-white/20 dark:bg-gray-900/80 dark:rounded-lg border border-gray-200/20 dark:border-gray-700/50 shadow-sm dark:shadow-lg dark:backdrop-blur-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.time_spent') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalTimeSpentHours }}h</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completion Rate -->
            <div class="bg-white/20 dark:bg-gray-900/80 dark:rounded-lg border border-gray-200/20 dark:border-gray-700/50 shadow-sm dark:shadow-lg dark:backdrop-blur-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Taxa de Conclusão</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $completionRate }}%</p>
                    </div>
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Time Tracking Widget -->
        <div id="active-tracking-widget" class="hidden bg-gradient-to-r from-green-500/20 to-emerald-500/20 dark:from-green-600/20 dark:to-emerald-600/20 border border-green-200/30 dark:border-green-700/50 rounded-xl p-6 mb-8 shadow-lg backdrop-blur-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="active-session-project">Projeto Ativo</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400" id="active-session-name">Sessão de Trabalho</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500" id="active-session-started">Iniciado há 0 minutos</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-green-600 dark:text-green-400" id="active-session-time">00:00</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Tempo Ativo</div>
                    <div class="flex items-center space-x-2 mt-2">
                        <button id="quick-pause" class="px-3 py-1 bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-700 dark:text-yellow-300 text-xs font-medium rounded-lg transition-colors">
                            Pausar
                        </button>
                        <button id="quick-stop" class="px-3 py-1 bg-red-500/20 hover:bg-red-500/30 text-red-700 dark:text-red-300 text-xs font-medium rounded-lg transition-colors">
                            Parar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            
            <!-- My Tasks Section -->
            <div class="bg-white/20 dark:bg-gray-900/80 dark:rounded-lg border border-gray-200/20 dark:border-gray-700/50 shadow-sm dark:shadow-lg dark:backdrop-blur-sm">
                <div class="p-6 border-b border-gray-200/50 dark:border-gray-700/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('messages.my_tasks') }}</h2>
                            <div class="w-6 h-6 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('tasks.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            {{ __('messages.create_task') }}
                        </a>
                    </div>
                </div>
                
                <!-- Task Tabs -->
                <div class="px-6 pt-4">
                    <div class="flex space-x-6 border-b border-gray-200/50 dark:border-gray-700/50">
                        <button id="upcomingTab" class="task-tab pb-3 text-sm font-medium text-gray-900 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600 transition-colors" data-tab="upcoming">
                            {{ __('messages.upcoming') }}
                        </button>
                        <button id="overdueTab" class="task-tab pb-3 text-sm font-medium text-gray-900 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600 transition-colors" data-tab="overdue">
                            {{ __('messages.overdue') }}
                        </button>
                        <button id="completedTab" class="task-tab pb-3 text-sm font-medium text-purple-600 dark:text-purple-400 border-b-2 border-purple-600 dark:border-purple-400" data-tab="completed">
                            {{ __('messages.completed') }}
                        </button>
                    </div>
                </div>

                <!-- Task List -->
                <div class="p-6">
                    <!-- Upcoming Tasks -->
                    <div id="upcomingTasks" class="task-content hidden">
                        <div class="space-y-3">
                            @if($upcomingTasks->count() > 0)
                                @foreach($upcomingTasks->take(7) as $task)
                                    <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                        <div class="w-5 h-5 border-2 border-blue-500 rounded-full flex items-center justify-center">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-900 dark:text-white">{{ $task->title }}</p>
                                            @if($task->description)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($task->description, 50) }}</p>
                                            @endif
                                            @if($task->due_date)
                                                <p class="text-xs text-blue-500 dark:text-blue-400 mt-1">
                                                    {{ __('messages.due') }}: {{ $task->due_date->format('d/m/Y') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="w-4 h-4 border border-gray-300 dark:border-gray-600 rounded-full"></div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_upcoming_tasks') }}</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($upcomingTasks->count() > 7)
                            <div class="mt-4 text-center">
                                <a href="{{ route('tasks.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium">
                                    {{ __('messages.show_more') }}
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Overdue Tasks -->
                    <div id="overdueTasks" class="task-content hidden">
                        <div class="space-y-3">
                            @if($overdueTasks->count() > 0)
                                @foreach($overdueTasks->take(7) as $task)
                                    <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                        <div class="w-5 h-5 bg-red-500 rounded-full flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-900 dark:text-white">{{ $task->title }}</p>
                                            @if($task->description)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($task->description, 50) }}</p>
                                            @endif
                                            @if($task->due_date)
                                                <p class="text-xs text-red-500 dark:text-red-400 mt-1">
                                                    {{ __('messages.overdue_since') }}: {{ $task->due_date->format('d/m/Y') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="w-4 h-4 border border-gray-300 dark:border-gray-600 rounded-full"></div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_overdue_tasks') }}</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($overdueTasks->count() > 7)
                            <div class="mt-4 text-center">
                                <a href="{{ route('tasks.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium">
                                    {{ __('messages.show_more') }}
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Completed Tasks -->
                    <div id="completedTasks" class="task-content">
                        <div class="space-y-3">
                            @if($completedTasksList->count() > 0)
                                @foreach($completedTasksList->take(7) as $task)
                                    <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                        <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-900 dark:text-white line-through">{{ $task->title }}</p>
                                            @if($task->description)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-through">{{ Str::limit($task->description, 50) }}</p>
                                            @endif
                                            @if($task->updated_at)
                                                <p class="text-xs text-green-500 dark:text-green-400 mt-1">
                                                    {{ __('messages.completed_on') }}: {{ $task->updated_at->format('d/m/Y') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="w-4 h-4 border border-gray-300 dark:border-gray-600 rounded-full"></div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="text-gray-900 dark:text-gray-400">{{ __('messages.no_completed_tasks') }}</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($completedTasksList->count() > 7)
                            <div class="mt-4 text-center">
                                <a href="{{ route('tasks.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium">
                                    {{ __('messages.show_more') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Projects Section -->
            <div class="bg-white/20 dark:bg-gray-900/80 dark:rounded-lg border border-gray-200/20 dark:border-gray-700/50 shadow-sm dark:shadow-lg dark:backdrop-blur-sm">
                <div class="p-6 border-b border-gray-200/50 dark:border-gray-700/50">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('messages.projects') }}</h2>
                        <a href="{{ route('projects.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            {{ __('messages.create_project') }}
                        </a>
                    </div>
                </div>
                
                <!-- Project Tabs -->
                <div class="px-6 pt-4">
                    <div class="flex space-x-6 border-b border-gray-200/50 dark:border-gray-700/50">
                        <button id="activeProjectsTab" class="project-tab pb-3 text-sm font-medium text-purple-600 dark:text-purple-400 border-b-2 border-purple-600 dark:border-purple-400" data-tab="active">
                            {{ __('messages.active') }}
                        </button>
                        <button id="archivedProjectsTab" class="project-tab pb-3 text-sm font-medium text-gray-900 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600 transition-colors" data-tab="archived">
                            {{ __('messages.archived') }}
                        </button>
                        <button id="favoriteProjectsTab" class="project-tab pb-3 text-sm font-medium text-gray-900 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600 transition-colors" data-tab="favorite">
                            {{ __('messages.favorites') }}
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    <!-- Active Projects -->
                    <div id="activeProjects" class="project-content">
                        <div class="space-y-3">
                            @if($activeProjects->count() > 0)
                                @foreach($activeProjects->take(5) as $project)
                                    <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                            <span class="text-white text-xs font-medium">{{ substr($project->name, 0, 2) }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $project->name }}</p>
                                            @if($project->description)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($project->description, 40) }}</p>
                                            @endif
                                            @if($project->programming_languages && count($project->programming_languages) > 0)
                                                <div class="flex flex-wrap gap-1 mt-2">
                                                    @foreach(array_slice($project->programming_languages, 0, 3) as $language)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                            {{ $language }}
                                                        </span>
                                                    @endforeach
                                                    @if(count($project->programming_languages) > 3)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                            +{{ count($project->programming_languages) - 3 }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $project->tasks_count ?? 0 }} {{ __('messages.tasks') }}</span>
                                            <button class="text-gray-400 hover:text-yellow-500 transition-colors" onclick="toggleProjectFavorite({{ $project->id }})">
                                                <svg class="w-4 h-4" fill="{{ $project->is_favorite ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_active_projects') }}</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($activeProjects->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="{{ route('projects.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium">
                                    {{ __('messages.show_more') }}
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Archived Projects -->
                    <div id="archivedProjects" class="project-content hidden">
                        <div class="space-y-3">
                            @if($archivedProjects->count() > 0)
                                @foreach($archivedProjects->take(5) as $project)
                                    <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors opacity-60">
                                        <div class="w-8 h-8 bg-gray-400 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                            <span class="text-white text-xs font-medium">{{ substr($project->name, 0, 2) }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white line-through">{{ $project->name }}</p>
                                            @if($project->description)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-through">{{ Str::limit($project->description, 40) }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $project->tasks_count ?? 0 }} {{ __('messages.tasks') }}</span>
                                            <span class="text-xs text-gray-400 dark:text-gray-500">{{ __('messages.archived') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 8l6 6 6-6"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_archived_projects') }}</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($archivedProjects->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="{{ route('projects.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium">
                                    {{ __('messages.show_more') }}
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Favorite Projects -->
                    <div id="favoriteProjects" class="project-content hidden">
                        <div class="space-y-3">
                            @if($favoriteProjects->count() > 0)
                                @foreach($favoriteProjects->take(5) as $project)
                                    <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                        <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center">
                                            <span class="text-white text-xs font-medium">{{ substr($project->name, 0, 2) }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $project->name }}</p>
                                            @if($project->description)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($project->description, 40) }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $project->tasks_count ?? 0 }} {{ __('messages.tasks') }}</span>
                                            <button class="text-yellow-500 hover:text-yellow-600 transition-colors" onclick="toggleProjectFavorite({{ $project->id }})">
                                                <svg class="w-4 h-4" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_favorite_projects') }}</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($favoriteProjects->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="{{ route('projects.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium">
                                    {{ __('messages.show_more') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Task tabs functionality
    const taskTabs = document.querySelectorAll('.task-tab');
    const taskContents = document.querySelectorAll('.task-content');

    taskTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all task tabs
            taskTabs.forEach(t => {
                t.classList.remove('text-purple-600', 'dark:text-purple-400', 'border-purple-600', 'dark:border-purple-400');
                t.classList.add('text-gray-900', 'dark:text-gray-400', 'border-transparent');
            });
            
            // Add active class to clicked tab
            this.classList.remove('text-gray-900', 'dark:text-gray-400', 'border-transparent');
            this.classList.add('text-purple-600', 'dark:text-purple-400', 'border-purple-600', 'dark:border-purple-400');
            
            // Hide all task contents
            taskContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show target content
            const targetContent = document.getElementById(targetTab + 'Tasks');
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }
        });
    });

    // Project tabs functionality
    const projectTabs = document.querySelectorAll('.project-tab');
    const projectContents = document.querySelectorAll('.project-content');

    projectTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all project tabs
            projectTabs.forEach(t => {
                t.classList.remove('text-purple-600', 'dark:text-purple-400', 'border-purple-600', 'dark:border-purple-400');
                t.classList.add('text-gray-900', 'dark:text-gray-400', 'border-transparent');
            });
            
            // Add active class to clicked tab
            this.classList.remove('text-gray-900', 'dark:text-gray-400', 'border-transparent');
            this.classList.add('text-purple-600', 'dark:text-purple-400', 'border-purple-600', 'dark:border-purple-400');
            
            // Hide all project contents
            projectContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show target content
            const targetContent = document.getElementById(targetTab + 'Projects');
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }
        });
    });
});

// Function to toggle project favorite status
function toggleProjectFavorite(projectId) {
    // Use the globally configured Axios instance
    window.axios.patch(`/projects/${projectId}/toggle-favorite`)
        .then(response => {
            if (response.data.success) {
                // Reload the page to update the project lists
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error toggling project favorite:', error);
        });
}
</script>

<style>
/* Transparência customizada para os cards */
.transparent-card {
    background-color: rgba(255, 255, 255, 0.2) !important;
    backdrop-filter: blur(10px) !important;
    -webkit-backdrop-filter: blur(10px) !important;
}

.dark .transparent-card {
    background-color: rgba(31, 41, 55, 0.5) !important;
}
</style>

<script>
// Time Tracking Widget
document.addEventListener('DOMContentLoaded', function() {
    const activeTrackingWidget = document.getElementById('active-tracking-widget');
    const activeSessionProject = document.getElementById('active-session-project');
    const activeSessionName = document.getElementById('active-session-name');
    const activeSessionStarted = document.getElementById('active-session-started');
    const activeSessionTime = document.getElementById('active-session-time');
    const quickPauseBtn = document.getElementById('quick-pause');
    const quickStopBtn = document.getElementById('quick-stop');

    let currentActiveSession = null;
    let timeUpdateInterval = null;

    // Verificar se há sessão ativa
    checkActiveSessions();

    // Event listeners para controles rápidos
    quickPauseBtn.addEventListener('click', togglePauseResume);
    quickStopBtn.addEventListener('click', stopActiveSession);

    async function checkActiveSessions() {
        try {
            // Buscar todas as sessões ativas do usuário
            const response = await fetch('/api/time-tracking/active-sessions');
            const data = await response.json();

            if (data.success && data.data.length > 0) {
                // Pegar a primeira sessão ativa
                currentActiveSession = data.data[0];
                showActiveTrackingWidget();
                startTimeUpdate();
            } else {
                hideActiveTrackingWidget();
            }
        } catch (error) {
            console.error('Erro ao verificar sessões ativas:', error);
        }
    }

    function showActiveTrackingWidget() {
        if (!currentActiveSession) return;

        activeTrackingWidget.classList.remove('hidden');
        activeSessionProject.textContent = currentActiveSession.project_name;
        activeSessionName.textContent = currentActiveSession.session_name || 'Sessão de Trabalho';
        
        // Calcular tempo desde o início
        const startTime = new Date(currentActiveSession.started_at);
        const now = new Date();
        const elapsedMs = now - startTime;
        const elapsedMinutes = Math.floor(elapsedMs / 60000);
        
        activeSessionStarted.textContent = `Iniciado há ${elapsedMinutes} minutos`;
        
        // Atualizar tempo decorrido
        updateElapsedTime();
    }

    function hideActiveTrackingWidget() {
        activeTrackingWidget.classList.add('hidden');
        stopTimeUpdate();
    }

    function startTimeUpdate() {
        if (timeUpdateInterval) {
            clearInterval(timeUpdateInterval);
        }
        
        timeUpdateInterval = setInterval(updateElapsedTime, 1000);
    }

    function stopTimeUpdate() {
        if (timeUpdateInterval) {
            clearInterval(timeUpdateInterval);
            timeUpdateInterval = null;
        }
    }

    function updateElapsedTime() {
        if (!currentActiveSession || currentActiveSession.status !== 'active') {
            return;
        }

        const startTime = new Date(currentActiveSession.started_at);
        const now = new Date();
        const elapsedMs = now - startTime;
        const elapsedMinutes = Math.floor(elapsedMs / 60000);
        
        const hours = Math.floor(elapsedMinutes / 60);
        const minutes = elapsedMinutes % 60;
        
        const formattedTime = hours > 0 
            ? `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`
            : `00:${minutes.toString().padStart(2, '0')}`;
        
        activeSessionTime.textContent = formattedTime;
        activeSessionStarted.textContent = `Iniciado há ${elapsedMinutes} minutos`;
    }

    async function togglePauseResume() {
        if (!currentActiveSession) return;

        const action = currentActiveSession.status === 'active' ? 'pause' : 'resume';

        try {
            const response = await fetch(`/api/time-tracking/${action}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    tracking_id: currentActiveSession.id
                })
            });

            const data = await response.json();

            if (data.success) {
                currentActiveSession = data.data;
                updateWidgetStatus();
            } else {
                alert(data.message || 'Erro ao alterar status da sessão');
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao alterar status da sessão');
        }
    }

    async function stopActiveSession() {
        if (!currentActiveSession) return;

        if (!confirm('Tem certeza que deseja parar esta sessão?')) {
            return;
        }

        try {
            const response = await fetch('/api/time-tracking/stop', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    tracking_id: currentActiveSession.id
                })
            });

            const data = await response.json();

            if (data.success) {
                currentActiveSession = null;
                hideActiveTrackingWidget();
                alert(`Sessão finalizada! Tempo total: ${data.data.formatted_duration}`);
                // Recarregar a página para atualizar estatísticas
                location.reload();
            } else {
                alert(data.message || 'Erro ao parar sessão');
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao parar sessão');
        }
    }

    function updateWidgetStatus() {
        if (!currentActiveSession) return;

        if (currentActiveSession.status === 'active') {
            quickPauseBtn.textContent = 'Pausar';
            quickPauseBtn.className = 'px-3 py-1 bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-700 dark:text-yellow-300 text-xs font-medium rounded-lg transition-colors';
            startTimeUpdate();
        } else {
            quickPauseBtn.textContent = 'Retomar';
            quickPauseBtn.className = 'px-3 py-1 bg-orange-500/20 hover:bg-orange-500/30 text-orange-700 dark:text-orange-300 text-xs font-medium rounded-lg transition-colors';
            stopTimeUpdate();
        }
    }

    // Limpar interval quando a página for fechada
    window.addEventListener('beforeunload', function() {
        stopTimeUpdate();
    });
});
</script>

@endsection
