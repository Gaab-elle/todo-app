@extends('layouts.app')

@section('title', __('messages.app_title'))

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in font-poppins">
    <!-- Navigation -->
    <nav class="mb-8 animate-slide-up">
        <div class="bg-glass backdrop-blur-md rounded-2xl border border-white/10 p-6 shadow-glass">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home.index') }}" 
                       class="flex items-center space-x-2 text-gray-400 hover:text-white transition-all duration-300 hover:scale-105 hover:shadow-glow rounded-lg px-3 py-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="font-medium">{{ __('messages.home') }}</span>
                    </a>
                    <a href="{{ route('tasks.index') }}" 
                       class="flex items-center space-x-2 text-white bg-gradient-primary rounded-lg px-3 py-2 shadow-glow">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span class="font-medium">{{ __('messages.tasks') }}</span>
                    </a>
                    <a href="{{ route('stats.index') }}" 
                       class="flex items-center space-x-2 text-gray-400 hover:text-white transition-all duration-300 hover:scale-105 hover:shadow-glow rounded-lg px-3 py-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="font-medium">{{ __('messages.statistics') }}</span>
                    </a>
                </div>
                
                <!-- Theme Toggle and Language Switcher -->
                <div class="flex items-center space-x-6">
                    <!-- Theme Toggle -->
                    <div class="flex items-center space-x-3">
                        <span class="text-sm dark:text-gray-400 light:text-gray-600 font-medium">{{ __('messages.theme') }}:</span>
                        <button class="theme-toggle" title="{{ __('messages.toggle_theme') }}">
                            <div class="theme-toggle-slider"></div>
                            <svg class="theme-toggle-icon theme-toggle-moon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" clip-rule="evenodd"></path>
                            </svg>
                            <svg class="theme-toggle-icon theme-toggle-sun" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Language Switcher -->
                    <div class="flex items-center space-x-3">
                        <span class="text-sm dark:text-gray-400 light:text-gray-600 font-medium">{{ __('messages.language') }}:</span>
                        <div class="flex space-x-2">
                            @foreach($availableLocales as $locale)
                                <a href="{{ route('locale.switch', $locale) }}" 
                                   class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-300 {{ $currentLocale === $locale ? 'bg-gradient-primary text-white shadow-glow' : 'bg-glass-dark dark:text-gray-300 light:text-gray-700 hover:bg-glass dark:hover:text-white light:hover:text-gray-900 hover:scale-105' }}">
                                    {{ strtoupper($locale) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="mb-8 animate-slide-up" style="animation-delay: 0.1s;">
        <h1 class="text-5xl font-bold dark:bg-gradient-to-r dark:from-white dark:via-blue-100 dark:to-purple-200 light:bg-gradient-to-r light:from-gray-800 light:via-gray-600 light:to-gray-700 bg-clip-text text-transparent mb-4 animate-float">{{ __('messages.my_tasks') }}</h1>
        <p class="dark:text-gray-300 light:text-gray-600 text-lg font-medium">{{ __('messages.manage_your_tasks') }}</p>
    </div>

    <!-- Add Task Form -->
    <div class="bg-glass backdrop-blur-md rounded-2xl dark:border-white/10 light:border-black/10 p-8 mb-8 shadow-glass hover:shadow-refined-lg transition-all duration-400 animate-slide-up" style="animation-delay: 0.2s;">
        <h2 class="text-2xl font-semibold dark:text-white light:text-gray-900 mb-6 flex items-center space-x-3">
            <div class="w-8 h-8 bg-gradient-primary rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <span>{{ __('messages.add_new_task') }}</span>
        </h2>
        
        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-200 mb-3">
                        {{ __('messages.title') }} *
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           required
                           class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                           placeholder="{{ __('messages.enter_task_title') }}">
                </div>
                
                <div>
                    <label for="priority" class="block text-sm font-semibold text-gray-200 mb-3">
                        {{ __('messages.priority') }} *
                    </label>
                    <select id="priority" 
                            name="priority" 
                            required
                            class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30">
                        <option value="">{{ __('messages.select_priority') }}</option>
                        <option value="low">{{ __('messages.low') }}</option>
                        <option value="medium">{{ __('messages.medium') }}</option>
                        <option value="high">{{ __('messages.high') }}</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-200 mb-3">
                    {{ __('messages.description') }}
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30 resize-none"
                          placeholder="{{ __('messages.describe_task') }}"></textarea>
            </div>
            
            <div>
                <label for="due_date" class="block text-sm font-semibold text-gray-200 mb-3">
                    {{ __('messages.due_date') }}
                </label>
                <input type="date" 
                       id="due_date" 
                       name="due_date"
                       class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30">
            </div>
            
            <div class="flex justify-end pt-4">
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-primary hover:shadow-glow text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2 focus:ring-offset-transparent hover:scale-105 transform">
                    {{ __('messages.create_task') }}
                </button>
            </div>
        </form>
    </div>
    <!-- Tasks List -->
    <div class="space-y-6">
        @forelse($tasks as $task)
            <div class="bg-glass backdrop-blur-md rounded-2xl border border-white/10 p-6 shadow-glass hover:shadow-refined-lg transition-all duration-400 animate-slide-up {{ $task->completed ? 'border-l-4 border-l-green-400' : 'border-l-4 border-l-blue-400' }} group hover:scale-[1.02] transform">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-4">
                            <h3 class="text-xl font-semibold {{ $task->completed ? 'line-through text-gray-400' : 'text-white' }} group-hover:text-blue-100 transition-colors duration-300">
                                {{ $task->title }}
                            </h3>
                            
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
                <div class="bg-glass backdrop-blur-md rounded-2xl border border-white/10 p-12 shadow-glass">
                    <div class="text-gray-400 text-lg mb-6">
                        <svg class="mx-auto h-20 w-20 mb-6 animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-200 mb-4">{{ __('messages.no_tasks') }}</h3>
                    <p class="text-gray-400 text-lg">{{ __('messages.no_tasks_description') }}</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
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