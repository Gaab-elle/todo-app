@extends('layouts.app')

@section('content')
<div class="min-h-screen dark:bg-gradient-to-br dark:from-slate-900 dark:via-purple-900 dark:to-slate-900 light:bg-gradient-to-br light:from-gray-100 light:via-gray-200 light:to-gray-300 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
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
                        
                        <!-- Development Status and Type -->
                        <div class="flex items-center space-x-3 mt-3">
                            @if($project->project_type)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                    {{ ucfirst($project->project_type) }}
                                </span>
                            @endif
                            @if($project->development_status)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    @if($project->development_status === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                    @elseif($project->development_status === 'paused') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                    @elseif($project->development_status === 'completed') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                    {{ ucfirst($project->development_status) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        {{ __('messages.edit') }}
                    </a>
                    <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gr                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              ay-600 hover:bg-gray-500 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        {{ __('messages.back') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Time Tracking Section -->
        <div class="bg-gray-700 rounded-2xl border border-gray-600 p-6 mb-8 shadow-lg animate-slide-up" style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('messages.time_tracking') }}
                </h2>
                <div id="tracking-status" class="text-sm text-gray-400">
                    <!-- Status será atualizado via JavaScript -->
                </div>
            </div>

            <!-- Time Tracking Controls -->
            <div id="time-tracking-controls" class="space-y-4">
                <!-- Session Info (quando ativa) -->
                <div id="active-session-info" class="hidden bg-gray-800/50 rounded-xl p-4 border border-gray-600/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 id="session-name" class="text-lg font-semibold text-white"></h3>
                            <p id="session-description" class="text-gray-400 text-sm"></p>
                            <p class="text-gray-500 text-xs mt-1">
                                {{ __('messages.started_at') }}: <span id="session-started-at"></span>
                            </p>
                        </div>
                        <div class="text-right">
                            <div id="elapsed-time" class="text-3xl font-bold text-green-400"></div>
                            <div class="text-sm text-gray-400">{{ __('messages.elapsed_time') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <div class="flex items-center space-x-4">
                    <!-- Start Button -->
                    <button id="start-tracking" 
                            class="px-6 py-3 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:ring-offset-2 focus:ring-offset-transparent hover:scale-105 transform">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h1m4 0h1m6-6a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('messages.start_tracking') }}
                    </button>

                    <!-- Pause/Resume Button -->
                    <button id="pause-resume-tracking" 
                            class="hidden px-6 py-3 bg-yellow-600 hover:bg-yellow-500 text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:ring-offset-2 focus:ring-offset-transparent hover:scale-105 transform">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span id="pause-resume-text">{{ __('messages.pause') }}</span>
                    </button>

                    <!-- Stop Button -->
                    <button id="stop-tracking" 
                            class="hidden px-6 py-3 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:ring-offset-2 focus:ring-offset-transparent hover:scale-105 transform">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10h6v4H9z"></path>
                        </svg>
                        {{ __('messages.stop_tracking') }}
                    </button>
                </div>

                <!-- Quick Session Start -->
                <div id="quick-start-form" class="hidden bg-gray-800/30 rounded-xl p-4 border border-gray-600/30">
                    <h4 class="text-white font-semibold mb-3">{{ __('messages.quick_start_session') }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="session-name-input" class="block text-sm font-medium text-gray-300 mb-2">
                                {{ __('messages.session_name') }}
                            </label>
                            <input type="text" 
                                   id="session-name-input" 
                                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-400/50"
                                   placeholder="{{ __('messages.enter_session_name') }}">
                        </div>
                        <div>
                            <label for="session-description-input" class="block text-sm font-medium text-gray-300 mb-2">
                                {{ __('messages.description') }}
                            </label>
                            <input type="text" 
                                   id="session-description-input" 
                                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-400/50"
                                   placeholder="{{ __('messages.enter_description') }}">
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 mt-4">
                        <button id="confirm-start" 
                                class="px-4 py-2 bg-green-600 hover:bg-green-500 text-white font-medium rounded-lg transition-colors">
                            {{ __('messages.start_session') }}
                        </button>
                        <button id="cancel-start" 
                                class="px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white font-medium rounded-lg transition-colors">
                            {{ __('messages.cancel') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="mt-6 pt-6 border-t border-gray-600/50">
                <h3 class="text-lg font-semibold text-white mb-4">{{ __('messages.tracking_statistics') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-600/50">
                        <div class="text-2xl font-bold text-blue-400" id="total-time">0h 0m</div>
                        <div class="text-sm text-gray-400">{{ __('messages.total_time') }}</div>
                    </div>
                    <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-600/50">
                        <div class="text-2xl font-bold text-green-400" id="today-time">0h 0m</div>
                        <div class="text-sm text-gray-400">{{ __('messages.today_time') }}</div>
                    </div>
                    <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-600/50">
                        <div class="text-2xl font-bold text-purple-400" id="week-time">0h 0m</div>
                        <div class="text-sm text-gray-400">{{ __('messages.week_time') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- API Integrations Section -->
        <div class="bg-gray-700 rounded-2xl border border-gray-600 p-6 mb-8 shadow-lg animate-slide-up" style="animation-delay: 0.3s;">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                    {{ __('messages.api_integrations') }}
                </h2>
                <button id="add-integration-btn" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-lg transition-colors">
                    + {{ __('messages.add_integration') }}
                </button>
            </div>

            <!-- Integrations List -->
            <div id="integrations-list" class="space-y-4">
                <!-- Integrations will be loaded here via JavaScript -->
            </div>

            <!-- Add Integration Modal -->
            <div id="add-integration-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-gray-800 rounded-xl p-6 w-full max-w-md mx-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-white">{{ __('messages.add_integration') }}</h3>
                        <button id="close-integration-modal" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form id="integration-form">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    {{ __('messages.provider') }}
                                </label>
                                <select id="integration-provider" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50">
                                    <option value="">{{ __('messages.select_provider') }}</option>
                                    <option value="github">GitHub</option>
                                    <option value="gitlab">GitLab</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    {{ __('messages.repository_full_name') }}
                                </label>
                                <input type="text" id="integration-repository" 
                                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50"
                                       placeholder="usuario/repositorio">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    {{ __('messages.access_token') }}
                                </label>
                                <input type="password" id="integration-token" 
                                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50"
                                       placeholder="{{ __('messages.enter_access_token') }}">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <label class="flex items-center">
                                    <input type="checkbox" id="integration-auto-tracking" checked class="mr-2">
                                    <span class="text-sm text-gray-300">{{ __('messages.auto_tracking') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" id="integration-sync-commits" checked class="mr-2">
                                    <span class="text-sm text-gray-300">{{ __('messages.sync_commits') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 mt-6">
                            <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white font-medium rounded-lg transition-colors">
                                {{ __('messages.add_integration') }}
                            </button>
                            <button type="button" id="cancel-integration" class="px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white font-medium rounded-lg transition-colors">
                                {{ __('messages.cancel') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Development Details Section -->
        <div class="bg-gray-700 rounded-2xl border border-gray-600 p-8 mb-8 shadow-lg animate-slide-up" style="animation-delay: 0.1s;">
            <h2 class="text-2xl font-bold text-white mb-6">{{ __('messages.development_details') }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Programming Languages -->
                @if($project->programming_languages && count($project->programming_languages) > 0)
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-3">{{ __('messages.programming_languages') }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($project->programming_languages as $language)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                    {{ $language }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Technologies Used -->
                @if($project->technologies_used && count($project->technologies_used) > 0)
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-3">{{ __('messages.technologies_used') }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($project->technologies_used as $technology)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                    {{ $technology }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Time and Dates -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-3">Tempo e Datas</h3>
                    <div class="space-y-2">
                        @if($project->time_spent > 0)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm text-gray-300">{{ __('messages.time_spent') }}: {{ round($project->time_spent / 60, 1) }}h</span>
                            </div>
                        @endif
                        @if($project->start_date)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-300">Início: {{ $project->start_date->format('d/m/Y') }}</span>
                            </div>
                        @endif
                        @if($project->end_date)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-300">Conclusão: {{ $project->end_date->format('d/m/Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Repository and Category -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-3">Links e Categoria</h3>
                    <div class="space-y-2">
                        @if($project->repository_url)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                <a href="{{ $project->repository_url }}" target="_blank" class="text-sm text-blue-400 hover:text-blue-300 transition-colors">
                                    {{ __('messages.view_repository') }}
                                </a>
                            </div>
                        @endif
                        @if($project->category)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span class="text-sm text-gray-300">{{ $project->category }}</span>
                            </div>
                        @endif
                    </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const projectId = {{ $project->id }};
    let currentSession = null;
    let timeUpdateInterval = null;

    // Elementos DOM
    const startBtn = document.getElementById('start-tracking');
    const pauseResumeBtn = document.getElementById('pause-resume-tracking');
    const stopBtn = document.getElementById('stop-tracking');
    const quickStartForm = document.getElementById('quick-start-form');
    const activeSessionInfo = document.getElementById('active-session-info');
    const elapsedTimeEl = document.getElementById('elapsed-time');
    const sessionNameEl = document.getElementById('session-name');
    const sessionDescriptionEl = document.getElementById('session-description');
    const sessionStartedAtEl = document.getElementById('session-started-at');
    const trackingStatusEl = document.getElementById('tracking-status');

    // Estatísticas
    const totalTimeEl = document.getElementById('total-time');
    const todayTimeEl = document.getElementById('today-time');
    const weekTimeEl = document.getElementById('week-time');

    // Inicializar
    loadTrackingStatus();
    loadStatistics();

    // Event Listeners
    startBtn.addEventListener('click', showQuickStartForm);
    document.getElementById('confirm-start').addEventListener('click', startTracking);
    document.getElementById('cancel-start').addEventListener('click', hideQuickStartForm);
    pauseResumeBtn.addEventListener('click', togglePauseResume);
    stopBtn.addEventListener('click', stopTracking);

    // Funções
    function showQuickStartForm() {
        quickStartForm.classList.remove('hidden');
        startBtn.classList.add('hidden');
    }

    function hideQuickStartForm() {
        quickStartForm.classList.add('hidden');
        startBtn.classList.remove('hidden');
    }

    async function startTracking() {
        const sessionName = document.getElementById('session-name-input').value || 'Sessão de Trabalho';
        const description = document.getElementById('session-description-input').value || '';

        try {
            const response = await fetch('/api/time-tracking/start', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    project_id: projectId,
                    session_name: sessionName,
                    description: description
                })
            });

            const data = await response.json();

            if (data.success) {
                currentSession = data.data;
                updateUIForActiveSession();
                hideQuickStartForm();
                startTimeUpdate();
                loadStatistics();
            } else {
                alert(data.message || 'Erro ao iniciar sessão');
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao iniciar sessão');
        }
    }

    async function togglePauseResume() {
        if (!currentSession) return;

        const action = currentSession.status === 'active' ? 'pause' : 'resume';

        try {
            const response = await fetch(`/api/time-tracking/${action}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    tracking_id: currentSession.id
                })
            });

            const data = await response.json();

            if (data.success) {
                currentSession = data.data;
                updateUIForActiveSession();
            } else {
                alert(data.message || 'Erro ao alterar status da sessão');
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao alterar status da sessão');
        }
    }

    async function stopTracking() {
        if (!currentSession) return;

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
                    tracking_id: currentSession.id
                })
            });

            const data = await response.json();

            if (data.success) {
                currentSession = null;
                updateUIForInactiveSession();
                stopTimeUpdate();
                loadStatistics();
                alert(`Sessão finalizada! Tempo total: ${data.data.formatted_duration}`);
            } else {
                alert(data.message || 'Erro ao parar sessão');
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao parar sessão');
        }
    }

    async function loadTrackingStatus() {
        try {
            const response = await fetch(`/api/time-tracking/status?project_id=${projectId}`);
            const data = await response.json();

            if (data.success && data.data.has_active_session) {
                currentSession = data.data;
                updateUIForActiveSession();
                startTimeUpdate();
            } else {
                updateUIForInactiveSession();
            }
        } catch (error) {
            console.error('Erro ao carregar status:', error);
        }
    }

    async function loadStatistics() {
        try {
            const response = await fetch(`/api/time-tracking/stats?project_id=${projectId}`);
            const data = await response.json();

            if (data.success) {
                totalTimeEl.textContent = data.data.total_time_formatted;
                todayTimeEl.textContent = data.data.today_time_formatted;
                weekTimeEl.textContent = data.data.week_time_formatted;
            }
        } catch (error) {
            console.error('Erro ao carregar estatísticas:', error);
        }
    }

    function updateUIForActiveSession() {
        if (!currentSession) return;

        // Mostrar informações da sessão
        activeSessionInfo.classList.remove('hidden');
        sessionNameEl.textContent = currentSession.session_name || 'Sessão de Trabalho';
        sessionDescriptionEl.textContent = currentSession.description || '';
        sessionStartedAtEl.textContent = new Date(currentSession.started_at).toLocaleString();

        // Mostrar botões de controle
        pauseResumeBtn.classList.remove('hidden');
        stopBtn.classList.remove('hidden');
        startBtn.classList.add('hidden');

        // Atualizar texto do botão pause/resume
        const pauseResumeText = document.getElementById('pause-resume-text');
        if (currentSession.status === 'active') {
            pauseResumeText.textContent = 'Pausar';
            pauseResumeBtn.className = pauseResumeBtn.className.replace('bg-yellow-600 hover:bg-yellow-500', 'bg-yellow-600 hover:bg-yellow-500');
            trackingStatusEl.textContent = 'Sessão ativa';
            trackingStatusEl.className = 'text-sm text-green-400';
        } else {
            pauseResumeText.textContent = 'Retomar';
            pauseResumeBtn.className = pauseResumeBtn.className.replace('bg-yellow-600 hover:bg-yellow-500', 'bg-orange-600 hover:bg-orange-500');
            trackingStatusEl.textContent = 'Sessão pausada';
            trackingStatusEl.className = 'text-sm text-yellow-400';
        }

        // Atualizar tempo decorrido
        updateElapsedTime();
    }

    function updateUIForInactiveSession() {
        activeSessionInfo.classList.add('hidden');
        pauseResumeBtn.classList.add('hidden');
        stopBtn.classList.add('hidden');
        startBtn.classList.remove('hidden');
        trackingStatusEl.textContent = 'Nenhuma sessão ativa';
        trackingStatusEl.className = 'text-sm text-gray-400';
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
        if (!currentSession || currentSession.status !== 'active') {
            return;
        }

        const startTime = new Date(currentSession.started_at);
        const now = new Date();
        const elapsedMs = now - startTime;
        const elapsedMinutes = Math.floor(elapsedMs / 60000);
        
        const hours = Math.floor(elapsedMinutes / 60);
        const minutes = elapsedMinutes % 60;
        
        const formattedTime = hours > 0 
            ? `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`
            : `00:${minutes.toString().padStart(2, '0')}`;
        
        elapsedTimeEl.textContent = formattedTime;
    }

    // Limpar interval quando a página for fechada
    window.addEventListener('beforeunload', function() {
        stopTimeUpdate();
    });
});
</script>
@endsection
