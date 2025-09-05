@extends('layouts.app')

@section('title', __('messages.app_title'))

@section('content')
<div class="max-w-6xl mx-auto animate-fade-in font-poppins">

    <!-- Header -->
    <div class="mb-12 text-center animate-slide-up">
        <h1 class="text-6xl font-bold text-white mb-6 animate-float">{{ __('messages.app_title') }}</h1>
        <p class="text-gray-300 text-xl font-medium">{{ __('messages.app_subtitle') }}</p>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Tasks -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-lg border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('messages.total') }}</p>
                    <p class="text-3xl font-bold text-white">{{ $totalTasks }}</p>
                </div>
                <div class="bg-blue-600 p-3 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completed Tasks -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-lg border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('messages.completed') }}</p>
                    <p class="text-3xl font-bold text-white">{{ $completedTasks }}</p>
                </div>
                <div class="bg-green-600 p-3 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-lg border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('messages.pending') }}</p>
                    <p class="text-3xl font-bold text-white">{{ $pendingTasks }}</p>
                </div>
                <div class="bg-yellow-600 p-3 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- High Priority -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-lg border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('messages.high_priority') }}</p>
                    <p class="text-3xl font-bold text-white">{{ $highPriorityTasks }}</p>
                </div>
                <div class="bg-red-600 p-3 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="bg-gray-800 rounded-lg p-6 shadow-lg mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold text-white">{{ __('messages.general_progress') }}</h3>
            <span class="text-2xl font-bold text-white">{{ $completionRate }}%</span>
        </div>
        <div class="w-full bg-gray-700 rounded-full h-4">
            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-4 rounded-full transition-all duration-500" {!! 'style="width: ' . $completionRate . '"' !!}></div>
        </div>
        <p class="text-gray-400 text-sm mt-2">{{ $completedTasks }} {{ __('messages.tasks_completed') }} de {{ $totalTasks }}</p>
    </div>

    <!-- Recent Tasks & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Tasks -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-lg">
            <h3 class="text-xl font-semibold text-white mb-4">{{ __('messages.recent_tasks') }}</h3>
            @if($recentTasks->count() > 0)
                <div class="space-y-3">%
                    @foreach($recentTasks as $task)
                        <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 rounded-full {{ $task->completed ? 'bg-green-500' : 'bg-yellow-500' }}"></div>
                                <span class="text-white {{ $task->completed ? 'line-through text-gray-400' : '' }}">{{ $task->title }}</span>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full text-white
                                @if($task->priority === 'high') bg-red-600
                                @elseif($task->priority === 'medium') bg-yellow-600
                                @else bg-green-600
                                @endif">
                                {{ __("messages.{$task->priority}") }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p class="text-gray-400">{{ __('messages.no_tasks') }}</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-lg">
            <h3 class="text-xl font-semibold text-white mb-4">{{ __('messages.quick_actions') }}</h3>
            <div class="space-y-4">
                <a href="{{ route('tasks.index') }}" 
                   class="flex items-center space-x-3 p-4 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors duration-200">
                    <div class="bg-blue-600 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-medium">{{ __('messages.view_all_tasks') }}</p>
                        <p class="text-gray-400 text-sm">{{ __('messages.manage_tasks') }}</p>
                    </div>
                </a>

                <a href="{{ route('stats.index') }}" 
                   class="flex items-center space-x-3 p-4 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors duration-200">
                    <div class="bg-green-600 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-medium">{{ __('messages.view_statistics') }}</p>
                        <p class="text-gray-400 text-sm">{{ __('messages.analytics_insights') }}</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
