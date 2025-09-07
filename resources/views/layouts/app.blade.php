<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ session('theme', 'dark') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Dev Project Manager')</title>
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/css/fab.css', 'resources/js/app.js', 'resources/js/fab.js', 'resources/js/vue-app.js'])
    
    @stack('styles')
    
    <!-- Translations for JavaScript -->
    <script>
        window.translations = {
            // Navigation
            'messages.home': '{{ __("messages.home") }}',
            'messages.tasks': '{{ __("messages.tasks") }}',
            'messages.projects': '{{ __("messages.projects") }}',
            'messages.kanban_board': '{{ __("messages.kanban_board") }}',
            'messages.statistics': '{{ __("messages.statistics") }}',
            'messages.theme': '{{ __("messages.theme") }}',
            'messages.language': '{{ __("messages.language") }}',
            'messages.toggle_theme': '{{ __("messages.toggle_theme") }}',
            
            // Task management
            'messages.manage_tasks_efficiently': '{{ __("messages.manage_tasks_efficiently") }}',
            'manage_tasks_efficiently': '{{ __("messages.manage_tasks_efficiently") }}',
            'messages.organize_your_work': '{{ __("messages.organize_your_work") }}',
            'messages.search_placeholder': '{{ __("messages.search_placeholder") }}',
            'messages.search': '{{ __("messages.search") }}',
            'messages.pending': '{{ __("messages.pending") }}',
            'messages.in_progress': '{{ __("messages.in_progress") }}',
            'messages.review': '{{ __("messages.review") }}',
            'messages.completed': '{{ __("messages.completed") }}',
            
            // Status without messages prefix for Vue
            'pending': '{{ __("messages.pending") }}',
            'in_progress': '{{ __("messages.in_progress") }}',
            'review': '{{ __("messages.review") }}',
            'completed': '{{ __("messages.completed") }}',
            
            // Other Vue translations
            'high': '{{ __("messages.high") }}',
            'medium': '{{ __("messages.medium") }}',
            'low': '{{ __("messages.low") }}',
            'add_new_task': '{{ __("messages.add_new_task") }}',
            'title': '{{ __("messages.title") }}',
            'description': '{{ __("messages.description") }}',
            'priority': '{{ __("messages.priority") }}',
            'cancel': '{{ __("messages.cancel") }}',
            'save_task': '{{ __("messages.save_task") }}',
            'enter_task_title': '{{ __("messages.enter_task_title") }}',
            'enter_task_description': '{{ __("messages.enter_task_description") }}',
            'no_pending_tasks': '{{ __("messages.no_pending_tasks") }}',
            'no_in_progress_tasks': '{{ __("messages.no_in_progress_tasks") }}',
            'no_review_tasks': '{{ __("messages.no_review_tasks") }}',
            'no_completed_tasks': '{{ __("messages.no_completed_tasks") }}',
            'edit_task': '{{ __("messages.edit_task") }}',
            'update_task': '{{ __("messages.update_task") }}',
            'confirm_delete': '{{ __("messages.confirm_delete") }}',
            'messages.no_tasks_found': '{{ __("messages.no_tasks_found") }}',
            'messages.no_tasks_description': '{{ __("messages.no_tasks_description") }}',
            'messages.create_first_task': '{{ __("messages.create_first_task") }}',
            'messages.loading': '{{ __("messages.loading") }}',
            'messages.error': '{{ __("messages.error") }}',
            'messages.try_again': '{{ __("messages.try_again") }}',
            
            // Task properties
            'messages.high': '{{ __("messages.high") }}',
            'high': '{{ __("messages.high") }}',
            'messages.medium': '{{ __("messages.medium") }}',
            'medium': '{{ __("messages.medium") }}',
            'messages.low': '{{ __("messages.low") }}',
            'low': '{{ __("messages.low") }}',
            'messages.subtasks': '{{ __("messages.subtasks") }}',
            'subtasks': '{{ __("messages.subtasks") }}',
            'messages.mark_completed': '{{ __("messages.mark_completed") }}',
            'mark_completed': '{{ __("messages.mark_completed") }}',
            'messages.delete_task': '{{ __("messages.delete_task") }}',
            'delete_task': '{{ __("messages.delete_task") }}',
            
            // Legacy keys (for compatibility)
            'confirmDelete': '{{ __("messages.confirm_delete") }}',
            'save': '{{ __("messages.save") }}',
            'cancel': '{{ __("messages.cancel") }}',
            'enterTaskTitle': '{{ __("messages.enter_task_title") }}',
            'describeTask': '{{ __("messages.describe_task") }}',
            'createTask': '{{ __("messages.create_task") }}',
            'editTask': '{{ __("messages.edit_task") }}',
            'deleteTask': '{{ __("messages.delete_task") }}',
            'markComplete': '{{ __("messages.mark_complete") }}',
            'markPending': '{{ __("messages.mark_pending") }}',
            'addNewTask': '{{ __("messages.add_new_task") }}',
            'add_new_task': '{{ __("messages.add_new_task") }}',
            'all': '{{ __("messages.all") }}',
            'title': '{{ __("messages.title") }}',
            'description': '{{ __("messages.description") }}',
            'priority': '{{ __("messages.priority") }}',
            'dueDate': '{{ __("messages.due_date") }}',
                                'goHome': '{{ __("messages.go_home") }}',
                    'viewTasks': '{{ __("messages.view_tasks") }}',
                    'createProject': '{{ __("messages.create_project") }}',
                    'viewStats': '{{ __("messages.view_stats") }}',
                    
                    // Kanban specific
                    'urgent': '{{ __("messages.urgent") }}',
                    'describe_task': '{{ __("messages.describe_task") }}',
                    'all_tasks': '{{ __("messages.all_tasks") }}',
                    'will_be_deleted': '{{ __("messages.will_be_deleted") }}',
                    'dont_show_again': '{{ __("messages.dont_show_again") }}',
                    'help': '{{ __("messages.help") }}',
                    'import_board': '{{ __("messages.import_board") }}',
                    'export_board': '{{ __("messages.export_board") }}'
        };
    </script>
    
    <!-- Dynamic theme styles -->
    <style>
        /* Base font family */
        body {
            font-family: 'Poppins', ui-sans-serif, system-ui, -apple-system, sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        /* Dark theme styles */
        .dark {
            color-scheme: dark;
        }
        
        .dark body {
            background-color: #111827;
            color: #ffffff;
        }
        
        /* Light theme styles */
        .light {
            color-scheme: light;
        }
        
        .light body {
            background-color: #f8fafc;
            color: #1f2937;
        }
        
        .light .bg-gray-700 {
            background-color: #9ca3af;
        }
        
        .light .bg-gray-800 {
            background-color: #d1d5db;
        }
        
        /* Cards - Darker in light mode */
        .light .bg-gray-800\/50 {
            background-color: rgba(209, 213, 219, 0.8);
        }
        
        .light .bg-gray-800\/30 {
            background-color: rgba(209, 213, 219, 0.6);
        }
        
        .light .bg-gray-700\/50 {
            background-color: rgba(156, 163, 175, 0.8);
        }
        
        .light .bg-gray-700\/30 {
            background-color: rgba(156, 163, 175, 0.6);
        }
        
        .light .text-white {
            color: #000000;
        }
        
        .light .text-gray-300 {
            color: #000000;
        }
        
        .light .text-gray-400 {
            color: #000000;
        }
        
        .light .border-gray-600 {
            border-color: #d1d5db;
        }
        
        /* Placeholder colors for light theme */
        .light .placeholder-gray-600::placeholder {
            color: #6b7280;
        }
        
        /* Text colors for light theme */
        .light .text-gray-800 {
            color: #000000;
        }
        
        .light .text-gray-700 {
            color: #000000;
        }
        
        .light .text-gray-600 {
            color: #000000;
        }
        
        /* Additional text colors for light theme */
        .light .text-gray-500 {
            color: #000000;
        }
        
        .light .text-gray-200 {
            color: #000000;
        }
        
        .light .text-gray-100 {
            color: #000000;
        }
        
        /* Dark theme overrides */
        .dark .placeholder-gray-600::placeholder {
            color: #9ca3af;
        }
        
        .dark .text-gray-800 {
            color: #f9fafb;
        }
        
        .dark .text-gray-700 {
            color: #e5e7eb;
        }
        
        .dark .text-gray-600 {
            color: #d1d5db;
        }
        
        /* Dynamic scrollbar styles */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        .dark ::-webkit-scrollbar-track {
            background: #374151;
        }
        
        .dark ::-webkit-scrollbar-thumb {
            background: #6b7280;
            border-radius: 4px;
        }
        
        .dark ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        .light ::-webkit-scrollbar-track {
            background: #f3f4f6;
        }
        
        .light ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }
        
        .light ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
</head>
<body class="min-h-screen antialiased transition-colors duration-300 bg-gray-50 dark:bg-gradient-to-br dark:from-slate-900/80 dark:via-purple-900/60 dark:to-slate-900/80">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="hidden lg:flex lg:w-16 lg:hover:w-64 bg-white dark:bg-gray-800/80 shadow-lg transition-all duration-300 ease-in-out group flex-col backdrop-blur-sm">
            <!-- User Profile Section -->
            <div class="flex items-center h-16 px-2 lg:px-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                <span class="text-white text-sm font-medium">{{ auth()->user()->initials }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="hidden lg:group-hover:block transition-opacity duration-300 overflow-hidden">
                        <p class="text-sm font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ auth()->user()->name ?? __('messages.user') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ auth()->user()->email ?? 'user@email.com' }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Profile Button -->
            <div class="px-2 py-2">
                <a href="{{ route('profile.public', auth()->user()->username ?? auth()->user()->id) }}" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="ml-3 hidden lg:group-hover:block transition-opacity duration-300 whitespace-nowrap">{{ __('messages.profile') }}</span>
                </a>
            </div>
            
            
            <!-- Navigation -->
            <nav class="mt-2 px-2 flex-1">
                <div class="space-y-1">
                    <a href="/" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ request()->is('/') ? 'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="ml-3 hidden lg:group-hover:block transition-opacity duration-300 whitespace-nowrap">{{ __('messages.home') }}</span>
                    </a>
                    
                    <a href="/tasks" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ request()->is('tasks*') ? 'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <span class="ml-3 hidden lg:group-hover:block transition-opacity duration-300 whitespace-nowrap">{{ __('messages.tasks') }}</span>
                    </a>
                    
                    <a href="/projects" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ request()->is('projects*') ? 'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="ml-3 hidden lg:group-hover:block transition-opacity duration-300 whitespace-nowrap">{{ __('messages.projects') }}</span>
                    </a>
                    
                    <a href="/stats" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ request()->is('stats*') ? 'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="ml-3 hidden lg:group-hover:block transition-opacity duration-300 whitespace-nowrap">{{ __('messages.statistics') }}</span>
                    </a>
                    
                    <a href="{{ route('profile.settings') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ request()->is('settings*') ? 'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="ml-3 hidden lg:group-hover:block transition-opacity duration-300 whitespace-nowrap">{{ __('messages.settings') }}</span>
                    </a>
                </div>
            </nav>
            
                <!-- Logout Button -->
                <div class="p-2 border-t border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium text-red-600 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="ml-3 hidden lg:group-hover:block transition-opacity duration-300 whitespace-nowrap">{{ __('messages.logout') }}</span>
                        </button>
                    </form>
                </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navigation -->
            <nav class="bg-white dark:bg-gray-900/80 shadow-lg border-b border-gray-200 dark:border-gray-700 backdrop-blur-sm">
                <div class="container mx-auto px-4">
                    <div class="flex items-center h-16">
                        <!-- Left: Menu Button (Mobile) -->
                        <div class="flex items-center lg:hidden w-16">
                            <button onclick="toggleSidebar()" class="text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Center: Search Bar -->
                        <div class="flex-1 flex justify-center">
                            <div class="relative w-full max-w-lg">
                                <form id="search-form" action="{{ route('search') }}" method="GET">
                                    <input type="text" id="search-input" name="q" placeholder="{{ __('messages.search_placeholder') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </form>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right: User Info, Theme Toggle, Language & Logout -->
                        <div class="flex items-center space-x-4 w-16 justify-end">
                            <!-- User Info (Desktop only) -->
                            <div class="hidden md:flex items-center space-x-2 text-sm">
                                <div class="w-6 h-6 rounded-full overflow-hidden">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                            <span class="text-white text-xs font-medium">{{ auth()->user()->initials }}</span>
                                        </div>
                                    @endif
                                </div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">{{ auth()->user()->name ?? __('messages.user') }}</span>
                            </div>
                            
                            <!-- Language Toggle -->
                            <div class="relative">
                                <button onclick="toggleLanguage()" class="flex items-center space-x-1 text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition-colors cursor-pointer" style="pointer-events: auto;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                    </svg>
                                    <span class="text-sm">{{ app()->getLocale() === 'pt' ? 'PT' : 'EN' }}</span>
                                </button>
                            </div>
                            
                            <!-- Theme Toggle -->
                            <button onclick="toggleTheme()" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                <svg id="theme-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                            </button>
                            
                                <!-- Logout Button -->
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors" title="{{ __('messages.logout') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                    </button>
                                </form>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Main Content -->
            <div class="flex-1">
    <div class="container mx-auto px-4 py-8">
        @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition 
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed top-4 right-4 bg-green-500 dark:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif
    
    @stack('scripts')
    
    <!-- Navigation JavaScript -->
    <script>
        // Sidebar toggle (for mobile)
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('lg:flex');
            }
        }
        
        // Logout function
        function logout() {
            if (confirm('{{ __("messages.confirm_logout") }}')) {
                // Clear any stored data
                localStorage.clear();
                sessionStorage.clear();
                
                // Redirect to logout or home page
                window.location.href = '/';
            }
        }
        
        // Profile function
        function openProfile() {
            // For now, just show an alert. You can implement a modal or redirect to profile page
            alert('{{ __("messages.profile_coming_soon") }}');
        }
        
        // Language toggle
        function toggleLanguage() {
            const currentLang = '{{ app()->getLocale() }}';
            const newLang = currentLang === 'pt' ? 'en' : 'pt';
            console.log('Current lang:', currentLang, 'New lang:', newLang);
            console.log('Redirecting to:', `/locale/${newLang}`);
            window.location.href = `/locale/${newLang}`;
        }
        
        // Theme toggle
        function toggleTheme() {
            const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            // Update theme icon
            const themeIcon = document.getElementById('theme-icon');
            if (newTheme === 'dark') {
                themeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>';
            } else {
                themeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>';
            }
            
            // Toggle theme
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', newTheme);
            
            // Update body class
            document.body.classList.toggle('dark');
            
            // Save theme to session via AJAX
            fetch('/theme/' + newTheme, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).catch(error => console.log('Theme save error:', error));
        }
        
        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            const sessionTheme = '{{ session('theme', 'dark') }}';
            const savedTheme = localStorage.getItem('theme') || sessionTheme;
            const themeIcon = document.getElementById('theme-icon');
            
            // Sync localStorage with session
            if (savedTheme !== sessionTheme) {
                localStorage.setItem('theme', sessionTheme);
            }
            
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
                if (themeIcon) {
                    themeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>';
                }
            }
            
            // Search functionality
            const searchForm = document.getElementById('search-form');
            const searchInput = document.getElementById('search-input');
            
            if (searchForm && searchInput) {
                // Handle form submission
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const query = searchInput.value.trim();
                    if (query) {
                        window.location.href = `{{ route('search') }}?q=${encodeURIComponent(query)}`;
                    }
                });
                
                // Handle Enter key
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const query = this.value.trim();
                        if (query) {
                            window.location.href = `{{ route('search') }}?q=${encodeURIComponent(query)}`;
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>