@extends('layouts.app')

@section('title', __('messages.statistics'))

@section('content')
<div class="max-w-6xl mx-auto">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-white mb-2">{{ __('messages.statistics') }}</h1>
        <p class="text-gray-400">{{ __('messages.analytics_insights') }}</p>
    </div>

    <!-- Main Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Tasks -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-lg border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('messages.total_tasks') }}</p>
                    <p class="text-3xl font-bold text-white">{{ $totalTasks }}</p>
                </div>
                <div class="bg-blue-600 p-3 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completion Rate -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-lg border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('messages.completion_rate') }}</p>
                    <p class="text-3xl font-bold text-white">{{ $completionRate }}%</p>
                </div>
                <div class="bg-green-600 p-3 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Overdue Tasks -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-lg border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('messages.overdue_tasks') }}</p>
                    <p class="text-3xl font-bold text-white">{{ $overdueTasks }}</p>
                </div>
                <div class="bg-red-600 p-3 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Average Completion Time -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-lg border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">{{ __('messages.avg_completion_time') }}</p>
                    <p class="text-3xl font-bold text-white">{{ $avgCompletionTime }}</p>
                    <p class="text-gray-400 text-xs">{{ __('messages.days') }}</p>
                </div>
                <div class="bg-purple-600 p-3 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Detailed Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Priority Distribution -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-lg">
            <h3 class="text-xl font-semibold text-white mb-6">{{ __('messages.priority_distribution') }}</h3>
            <div class="space-y-4">
                @php
                    $priorities = ['high' => 'red', 'medium' => 'yellow', 'low' => 'green'];
                @endphp
                @foreach($priorities as $priority => $color)
                    @php
                        $count = $priorityStats->get($priority, 0);
                        $percentage = $totalTasks > 0 ? round(($count / $totalTasks) * 100, 1) : 0;
                    @endphp
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 rounded-full bg-{{ $color }}-500"></div>
                            <span class="text-white font-medium">{{ __("messages.{$priority}") }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-gray-400">{{ $count }}</span>
                            <span class="text-gray-500 text-sm">({{ $percentage }}%)</span>
                        </div>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-2">
                        <div class="bg-{{ $color }}-500 h-2 rounded-full transition-all duration-500" style="--width: {{ $percentage }}%; width: var(--width);"></div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Task Status -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-lg">
            <h3 class="text-xl font-semibold text-white mb-6">{{ __('messages.task_status') }}</h3>
            <div class="space-y-4">
                <!-- Completed -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 rounded-full bg-green-500"></div>
                        <span class="text-white font-medium">{{ __('messages.completed') }}</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-gray-400">{{ $completedTasks }}</span>
                        <span class="text-gray-500 text-sm">({{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0 }}%)</span>
                    </div>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full transition-all duration-500" style="--width: {{ $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0 }}%; width: var(--width);"></div>
                </div>

                <!-- Pending -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 rounded-full bg-yellow-500"></div>
                        <span class="text-white font-medium">{{ __('messages.pending') }}</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-gray-400">{{ $pendingTasks }}</span>
                        <span class="text-gray-500 text-sm">({{ $totalTasks > 0 ? round(($pendingTasks / $totalTasks) * 100, 1) : 0 }}%)</span>
                    </div>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full transition-all duration-500" style="--width: {{ $totalTasks > 0 ? ($pendingTasks / $totalTasks) * 100 : 0 }}%; width: var(--width);"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Activity -->
    <div class="bg-gray-800 rounded-lg p-6 shadow-lg">
        <h3 class="text-xl font-semibold text-white mb-6">{{ __('messages.monthly_activity') }}</h3>
        @if($monthlyStats->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($monthlyStats as $stat)
                    <div class="text-center">
                        <div class="bg-gray-700 rounded-lg p-4">
                            <p class="text-gray-400 text-sm">{{ \Carbon\Carbon::createFromFormat('Y-m', $stat->month)->format('M Y') }}</p>
                            <p class="text-2xl font-bold text-white">{{ $stat->count }}</p>
                            <p class="text-gray-400 text-xs">{{ __('messages.tasks') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <p class="text-gray-400">{{ __('messages.no_data_available') }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
