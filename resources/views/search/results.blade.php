@extends('layouts.app')

@section('title', __('messages.search_results'))

@section('content')
<div class="min-h-screen">
    <!-- Search Header -->
    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border-b border-gray-200/50 dark:border-gray-700/50 px-6 py-4 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ __('messages.search_results') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-300 mt-1">
                    {{ __('messages.searching_for') }}: <span class="font-medium text-purple-600 dark:text-purple-400">"{{ $query }}"</span>
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span>{{ $tasks->count() }} {{ __('messages.tasks') }}</span>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>{{ $projects->count() }} {{ __('messages.projects') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Tasks Results -->
            <div class="rounded-lg border border-gray-200/50 dark:border-gray-700/50" style="background-color: rgba(0, 0, 0, 0.2) !important; backdrop-filter: blur(15px) !important; -webkit-backdrop-filter: blur(15px) !important;">
                <div class="p-6 border-b border-gray-200/50 dark:border-gray-700/50">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('messages.tasks') }}</h2>
                        <span class="bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-2 py-1 rounded-full text-xs font-medium">
                            {{ $tasks->count() }}
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($tasks->count() > 0)
                        <div class="space-y-3">
                            @foreach($tasks as $task)
                                <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <div class="w-5 h-5 border-2 border-purple-500 rounded-full flex items-center justify-center">
                                        <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $task->title }}</p>
                                        @if($task->description)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($task->description, 50) }}</p>
                                        @endif
                                        @if($task->project)
                                            <p class="text-xs text-purple-500 dark:text-purple-400 mt-1">
                                                {{ __('messages.project') }}: {{ $task->project->name }}
                                            </p>
                                        @endif
                                        @if($task->due_date)
                                            <p class="text-xs text-blue-500 dark:text-blue-400 mt-1">
                                                {{ __('messages.due') }}: {{ $task->due_date->format('d/m/Y') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                            {{ __('messages.' . $task->status) }}
                                        </span>
                                        <a href="{{ route('tasks.index') }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_tasks_found') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Projects Results -->
            <div class="rounded-lg border border-gray-200/50 dark:border-gray-700/50" style="background-color: rgba(0, 0, 0, 0.2) !important; backdrop-filter: blur(15px) !important; -webkit-backdrop-filter: blur(15px) !important;">
                <div class="p-6 border-b border-gray-200/50 dark:border-gray-700/50">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('messages.projects') }}</h2>
                        <span class="bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-2 py-1 rounded-full text-xs font-medium">
                            {{ $projects->count() }}
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($projects->count() > 0)
                        <div class="space-y-3">
                            @foreach($projects as $project)
                                <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                        <span class="text-white text-xs font-medium">{{ substr($project->name, 0, 2) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $project->name }}</p>
                                        @if($project->description)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($project->description, 40) }}</p>
                                        @endif
                                        <p class="text-xs text-purple-500 dark:text-purple-400 mt-1">
                                            {{ $project->tasks_count ?? 0 }} {{ __('messages.tasks') }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs px-2 py-1 rounded-full {{ $project->is_active ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300' }}">
                                            {{ $project->is_active ? __('messages.active') : __('messages.archived') }}
                                        </span>
                                        <a href="{{ route('projects.show', $project) }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_projects_found') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
