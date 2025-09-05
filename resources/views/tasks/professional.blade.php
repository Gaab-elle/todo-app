@extends('layouts.app')

@section('title', __('messages.my_tasks'))

@section('content')
<div class="min-h-screen dark:bg-gray-900 light:bg-gray-50 transition-colors duration-300" 
     x-data="taskManager()" 
     data-tasks="{{ json_encode($tasks) }}">
    
    <!-- Modern Vuetify-Inspired Toolbar -->
    <div class="relative overflow-hidden h-48 mb-8 rounded-2xl">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-blue-600 to-indigo-800"></div>
        <div class="absolute inset-0 bg-[url('https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg')] bg-cover bg-center opacity-30"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/30 to-transparent"></div>
        
        <!-- Toolbar Content -->
        <div class="relative z-10 h-full flex flex-col">
            <!-- Top Toolbar -->
            <div class="flex items-center justify-between px-6 py-4">
                <!-- Left Section -->
                <div class="flex items-center space-x-4">
                    <!-- Mobile Menu Button -->
                    <button class="text-white hover:bg-white/10 p-2 rounded-lg transition-all duration-200 lg:hidden" x-data @click="$dispatch('toggle-mobile-menu')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <!-- Menu Button -->
                    <button class="text-white hover:bg-white/10 p-2 rounded-lg transition-all duration-200 hidden lg:block" x-data @click="$dispatch('toggle-sidebar')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <!-- App Title -->
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 backdrop-blur-sm p-2 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-white font-poppins hidden sm:block">TaskFlow Pro</h1>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-3">
                    <!-- Search Bar -->
                    <div class="relative hidden md:block">
                        <input type="text" 
                               x-model="searchQuery"
                               :placeholder="'{{ __('messages.search_tasks') }}'"
                               class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-lg px-4 py-2 pl-10 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 focus:bg-white/30 transition-all w-64">
                        <svg class="w-5 h-5 text-white/70 absolute left-3 top-1/2 transform -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>

                    <!-- Theme Toggle -->
                    <button class="theme-toggle-alt bg-white/20 backdrop-blur-sm hover:bg-white/30 p-2 rounded-lg transition-all duration-200" title="{{ __('messages.toggle_theme') }}">
                        <div class="relative w-6 h-6">
                            <svg class="theme-icon-sun absolute inset-0 w-6 h-6 text-white transition-all duration-300 opacity-0 dark:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                            </svg>
                            <svg class="theme-icon-moon absolute inset-0 w-6 h-6 text-white transition-all duration-300 opacity-100 dark:opacity-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- Language Selector -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="bg-white/20 backdrop-blur-sm hover:bg-white/30 border border-white/30 px-3 py-2 rounded-lg flex items-center space-x-2 text-white transition-all duration-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7 2a1 1 0 011 1v1h3a1 1 0 110 2H9.578a18.87 18.87 0 01-1.724 4.78c.29.354.596.696.914 1.026a1 1 0 11-1.44 1.389c-.188-.196-.373-.396-.554-.6a19.098 19.098 0 01-3.107 3.567 1 1 0 01-1.334-1.49 17.087 17.087 0 003.13-3.733 18.992 18.992 0 01-1.487-2.494 1 1 0 111.79-.89c.234.47.489.928.764 1.372.417-.934.752-1.913.997-2.927H3a1 1 0 110-2h3V3a1 1 0 011-1zm6 6a1 1 0 01.894.553l2.991 5.982a.869.869 0 01.02.037l.99 1.98a1 1 0 11-1.79.895L15.383 16h-4.764l-.724 1.447a1 1 0 11-1.788-.894l.99-1.98.019-.038 2.99-5.982A1 1 0 0113 8zm-1.382 6h2.764L13 11.236 11.618 14z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ strtoupper(app()->getLocale()) }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-40 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md border border-white/20 rounded-xl shadow-refined-lg z-50">
                            @foreach($availableLocales as $locale)
                                <a href="{{ route('locale.switch', $locale) }}" 
                                   class="flex items-center px-4 py-3 text-sm dark:text-white light:text-gray-900 hover:bg-white/20 {{ $loop->first ? 'rounded-t-xl' : '' }} {{ $loop->last ? 'rounded-b-xl' : '' }} transition-colors {{ $currentLocale === $locale ? 'bg-gradient-primary text-white' : '' }}">
                                    <span class="mr-3">{{ $locale === 'pt' ? '🇧🇷' : '🇺🇸' }}</span>
                                    {{ $locale === 'pt' ? 'Português' : 'English' }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Export/Actions Button -->
                    <button class="text-white hover:bg-white/10 p-2 rounded-lg transition-all duration-200" title="Export Tasks">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Bottom Section with Breadcrumbs/Stats -->
            <div class="flex-1 flex items-end px-6 pb-6">
                <div class="w-full">
                    <div class="flex items-end justify-between">
                        <div>
                            <p class="text-white/80 text-sm mb-1">{{ __('messages.my_tasks') }}</p>
                            <h2 class="text-3xl font-bold text-white">{{ __('messages.task_management') }}</h2>
                        </div>
                        
                        <!-- Quick Stats -->
                        <div class="hidden lg:flex items-center space-x-6 text-white">
                            <div class="text-center">
                                <div class="text-2xl font-bold" x-text="totalTasks">{{ $tasks->count() }}</div>
                                <div class="text-xs text-white/80">{{ __('messages.total') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-300" x-text="completedTasks">{{ $tasks->where('completed', true)->count() }}</div>
                                <div class="text-xs text-white/80">{{ __('messages.completed') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-orange-300" x-text="pendingTasks">{{ $tasks->where('completed', false)->count() }}</div>
                                <div class="text-xs text-white/80">{{ __('messages.pending') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-8">
        
        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Tasks -->
            <div class="dashboard-card bg-glass dark:border-white/10 light:border-black/10 border rounded-2xl p-6 hover:shadow-refined-lg transition-all duration-300 animate-fade-in">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="dark:text-gray-400 light:text-gray-600 text-sm font-medium">{{ __('messages.total') }}</p>
                        <p class="text-3xl font-bold dark:text-white light:text-gray-900 mt-1" x-text="totalTasks">{{ $tasks->count() }}</p>
                        <p class="dark:text-gray-500 light:text-gray-500 text-xs mt-2">+12% {{ __('messages.this_month') }}</p>
                    </div>
                    <div class="bg-blue-500/20 p-3 rounded-xl">
                        <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed -->
            <div class="dashboard-card bg-glass dark:border-white/10 light:border-black/10 border rounded-2xl p-6 hover:shadow-refined-lg transition-all duration-300 animate-fade-in delay-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="dark:text-gray-400 light:text-gray-600 text-sm font-medium">{{ __('messages.completed') }}</p>
                        <p class="text-3xl font-bold dark:text-white light:text-gray-900 mt-1" x-text="completedTasks">{{ $tasks->where('completed', true)->count() }}</p>
                        <p class="text-green-400 text-xs mt-2">+8% {{ __('messages.this_week') }}</p>
                    </div>
                    <div class="bg-green-500/20 p-3 rounded-xl">
                        <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="dashboard-card bg-glass dark:border-white/10 light:border-black/10 border rounded-2xl p-6 hover:shadow-refined-lg transition-all duration-300 animate-fade-in delay-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="dark:text-gray-400 light:text-gray-600 text-sm font-medium">{{ __('messages.pending') }}</p>
                        <p class="text-3xl font-bold dark:text-white light:text-gray-900 mt-1" x-text="pendingTasks">{{ $tasks->where('completed', false)->count() }}</p>
                        <p class="text-orange-400 text-xs mt-2">4 {{ __('messages.due_today') }}</p>
                    </div>
                    <div class="bg-orange-500/20 p-3 rounded-xl">
                        <svg class="w-8 h-8 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- High Priority -->
            <div class="dashboard-card bg-glass dark:border-white/10 light:border-black/10 border rounded-2xl p-6 hover:shadow-refined-lg transition-all duration-300 animate-fade-in delay-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="dark:text-gray-400 light:text-gray-600 text-sm font-medium">{{ __('messages.high_priority') }}</p>
                        <p class="text-3xl font-bold dark:text-white light:text-gray-900 mt-1" x-text="highPriorityTasks">{{ $tasks->where('priority', 'high')->count() }}</p>
                        <p class="text-red-400 text-xs mt-2">{{ __('messages.attention_needed') }}</p>
                    </div>
                    <div class="bg-red-500/20 p-3 rounded-xl">
                        <svg class="w-8 h-8 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botão de Nova Tarefa -->
        <div class="mb-6">
            <button @click="showCreateForm = true" 
                    class="btn-primary hover:shadow-glow text-white px-8 py-4 rounded-xl font-semibold font-poppins flex items-center space-x-3 transition-all duration-300 hover:-translate-y-1">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ __('messages.add_new_task') }}</span>
            </button>
        </div>

        <!-- Filtros Melhorados -->
        <div class="flex flex-wrap gap-3 mb-8">
            <button @click="currentFilter = 'all'" 
                    :class="currentFilter === 'all' ? 'bg-gradient-primary text-white shadow-glow filter-active' : 'bg-glass dark:text-gray-300 light:text-gray-700 hover:bg-glass-dark dark:hover:text-white light:hover:text-gray-900 dark:border-white/10 light:border-black/10 border'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                {{ __('messages.all') }}
            </button>
            <button @click="currentFilter = 'pending'" 
                    :class="currentFilter === 'pending' ? 'bg-orange-600 text-white shadow-glow-yellow filter-active' : 'bg-glass dark:text-gray-300 light:text-gray-700 hover:bg-glass-dark dark:hover:text-white light:hover:text-gray-900 dark:border-white/10 light:border-black/10 border'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                {{ __('messages.pending') }}
            </button>
            <button @click="currentFilter = 'completed'" 
                    :class="currentFilter === 'completed' ? 'bg-green-600 text-white shadow-glow-green filter-active' : 'bg-glass dark:text-gray-300 light:text-gray-700 hover:bg-glass-dark dark:hover:text-white light:hover:text-gray-900 dark:border-white/10 light:border-black/10 border'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                {{ __('messages.completed') }}
            </button>
            <button @click="currentFilter = 'high'" 
                    :class="currentFilter === 'high' ? 'bg-red-600 text-white shadow-glow-red filter-active' : 'bg-glass dark:text-gray-300 light:text-gray-700 hover:bg-glass-dark dark:hover:text-white light:hover:text-gray-900 dark:border-white/10 light:border-black/10 border'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                {{ __('messages.high_priority') }}
            </button>
            <button @click="currentFilter = 'medium'" 
                    :class="currentFilter === 'medium' ? 'bg-yellow-600 text-white shadow-glow-yellow filter-active' : 'bg-glass dark:text-gray-300 light:text-gray-700 hover:bg-glass-dark dark:hover:text-white light:hover:text-gray-900 dark:border-white/10 light:border-black/10 border'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                {{ __('messages.medium_priority') }}
            </button>
            <button @click="currentFilter = 'low'" 
                    :class="currentFilter === 'low' ? 'bg-blue-600 text-white shadow-glow filter-active' : 'bg-glass dark:text-gray-300 light:text-gray-700 hover:bg-glass-dark dark:hover:text-white light:hover:text-gray-900 dark:border-white/10 light:border-black/10 border'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                {{ __('messages.low_priority') }}
            </button>
        </div>

        <!-- Lista de Tarefas Profissional -->
        <div class="space-y-4 custom-scrollbar max-h-96 overflow-y-auto">
            <template x-for="task in filteredTasks" :key="task.id">
                <div class="task-item bg-glass dark:border-white/10 light:border-black/10 border rounded-2xl p-6 hover:shadow-refined-lg hover:border-blue-500/50 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4 mb-3">
                                <button @click="toggleTask(task)" 
                                        :class="task.completed ? 'text-green-400 bg-green-500/20' : 'dark:text-gray-400 light:text-gray-500 hover:text-green-400 hover:bg-green-500/10'"
                                        class="p-2 rounded-lg transition-all duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <h3 class="font-semibold font-poppins text-lg" 
                                    :class="task.completed ? 'line-through dark:text-gray-400 light:text-gray-500' : 'dark:text-white light:text-gray-900'"
                                    x-text="task.title"></h3>
                                <span class="px-3 py-1 text-xs font-medium rounded-full border"
                                      :class="{
                                          'priority-high': task.priority === 'high',
                                          'priority-medium': task.priority === 'medium',
                                          'priority-low': task.priority === 'low'
                                      }"
                                      x-text="getPriorityText(task.priority)"></span>
                            </div>
                            <p class="dark:text-gray-300 light:text-gray-600 mb-3 leading-relaxed" x-text="task.description"></p>
                            <div class="text-sm dark:text-gray-400 light:text-gray-500 flex items-center space-x-4">
                                <span class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span x-text="formatDate(task.created_at)"></span>
                                </span>
                                <template x-if="task.due_date">
                                    <span class="flex items-center space-x-1 text-orange-400">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span x-text="formatDate(task.due_date)"></span>
                                    </span>
                                </template>
                            </div>
                        </div>
                        <div class="flex space-x-2 ml-6">
                            <button @click="editTask(task)" 
                                    class="text-blue-400 hover:text-blue-300 hover:bg-blue-500/10 p-3 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </button>
                            <button @click="deleteTask(task)" 
                                    class="text-red-400 hover:text-red-300 hover:bg-red-500/10 p-3 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Estado Vazio Melhorado -->
            <div x-show="filteredTasks.length === 0" class="text-center py-16">
                <div class="bg-glass dark:border-white/10 light:border-black/10 rounded-2xl p-8 border">
                    <svg class="w-20 h-20 mx-auto dark:text-gray-500 light:text-gray-400 mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                    <h3 class="text-xl font-semibold dark:text-white light:text-gray-900 mb-2">{{ __('messages.no_tasks') }}</h3>
                    <p class="dark:text-gray-400 light:text-gray-600 mb-6">{{ __('messages.start_creating_task') }}</p>
                    <button @click="showCreateForm = true" 
                            class="bg-gradient-primary hover:shadow-glow text-white px-6 py-3 rounded-xl font-medium transition-all duration-300">
                        {{ __('messages.create_task') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Progresso Geral Melhorado -->
        @php
            $progress = $tasks->count() > 0 ? round($tasks->where('completed', true)->count() / $tasks->count() * 100) : 0;
        @endphp
        <div class="mt-12 bg-glass dark:border-white/10 light:border-black/10 border rounded-2xl p-8 hover:shadow-refined-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold font-poppins dark:text-white light:text-gray-900">{{ __('messages.general_progress') }}</h3>
                <span class="text-3xl font-bold dark:text-white light:text-gray-900" x-text="Math.round(progress) + '%'">{{ $progress }}%</span>
            </div>
            <div class="mb-4">
                <div class="w-full dark:bg-gray-700 light:bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="progress-bar bg-gradient-primary h-3 rounded-full shadow-glow" 
                         :style="'width: ' + progress + '%'"></div>
                </div>
            </div>
            <p class="dark:text-gray-300 light:text-gray-600">
                <span class="dark:text-white light:text-gray-900 font-semibold" x-text="completedTasks">{{ $tasks->where('completed', true)->count() }}</span> 
                {{ __('messages.of') }}
                <span class="dark:text-white light:text-gray-900 font-semibold" x-text="totalTasks">{{ $tasks->count() }}</span>
                {{ __('messages.tasks_completed') }}
            </p>
        </div>
    </div>

    <!-- Modal Profissional -->
    @include('tasks.partials.professional-modal')
</div>

<script>
function taskManager() {
    return {
        // Estado inicial
        tasks: JSON.parse(this.$el.dataset.tasks),
        currentFilter: 'all',
        searchQuery: '',
        showCreateForm: false,
        showEditForm: false,
        editingTask: null,
        formData: {
            title: '',
            description: '',
            priority: 'medium',
            due_date: ''
        },

        // Computed properties
        get filteredTasks() {
            let filtered = this.tasks;
            
            // Filtro por busca
            if (this.searchQuery) {
                filtered = filtered.filter(task => 
                    task.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    (task.description && task.description.toLowerCase().includes(this.searchQuery.toLowerCase()))
                );
            }
            
            // Filtro por categoria
            return filtered.filter(task => {
                switch (this.currentFilter) {
                    case 'pending':
                        return !task.completed;
                    case 'completed':
                        return task.completed;
                    case 'high':
                        return task.priority === 'high';
                    case 'medium':
                        return task.priority === 'medium';
                    case 'low':
                        return task.priority === 'low';
                    default:
                        return true;
                }
            });
        },

        get totalTasks() {
            return this.tasks.length;
        },

        get completedTasks() {
            return this.tasks.filter(task => task.completed).length;
        },

        get pendingTasks() {
            return this.tasks.filter(task => !task.completed).length;
        },

        get highPriorityTasks() {
            return this.tasks.filter(task => task.priority === 'high').length;
        },

        get progress() {
            return this.totalTasks > 0 ? (this.completedTasks / this.totalTasks) * 100 : 0;
        },

        // Métodos
        getPriorityText(priority) {
            const priorities = {
                'high': window.translations?.high || 'Alta',
                'medium': window.translations?.medium || 'Média',
                'low': window.translations?.low || 'Baixa'
            };
            return priorities[priority] || priority;
        },

        formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('pt-BR');
        },

        resetForm() {
            this.formData = {
                title: '',
                description: '',
                priority: 'medium',
                due_date: ''
            };
        },

        closeModal() {
            this.showCreateForm = false;
            this.showEditForm = false;
            this.editingTask = null;
            this.resetForm();
        },

        async createTask() {
            try {
                const response = await fetch('/tasks', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(this.formData)
                });

                if (response.ok) {
                    const newTask = await response.json();
                    this.tasks.push(newTask);
                    this.closeModal();
                } else {
                    console.error('Erro ao criar tarefa');
                }
            } catch (error) {
                console.error('Erro:', error);
            }
        },

        editTask(task) {
            this.editingTask = task;
            this.formData = {
                title: task.title,
                description: task.description || '',
                priority: task.priority,
                due_date: task.due_date || ''
            };
            this.showEditForm = true;
        },

        async updateTask() {
            try {
                const response = await fetch(`/tasks/${this.editingTask.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(this.formData)
                });

                if (response.ok) {
                    const updatedTask = await response.json();
                    const index = this.tasks.findIndex(t => t.id === this.editingTask.id);
                    if (index !== -1) {
                        this.tasks[index] = updatedTask;
                    }
                    this.closeModal();
                } else {
                    console.error('Erro ao atualizar tarefa');
                }
            } catch (error) {
                console.error('Erro:', error);
            }
        },

        async toggleTask(task) {
            try {
                const response = await fetch(`/tasks/${task.id}/toggle`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    task.completed = !task.completed;
                } else {
                    console.error('Erro ao alterar status da tarefa');
                }
            } catch (error) {
                console.error('Erro:', error);
            }
        },

        async deleteTask(task) {
            if (!confirm(window.translations?.confirmDelete || 'Tem certeza que deseja excluir esta tarefa?')) {
                return;
            }

            try {
                const response = await fetch(`/tasks/${task.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    this.tasks = this.tasks.filter(t => t.id !== task.id);
                } else {
                    console.error('Erro ao excluir tarefa');
                }
            } catch (error) {
                console.error('Erro:', error);
            }
        }
    }
}
</script>
@endsection
