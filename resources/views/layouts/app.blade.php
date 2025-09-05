<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ session('theme', 'dark') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'To-Do App Laravel')</title>
    
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
<body class="min-h-screen antialiased transition-colors duration-300">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-lg border-b border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo/Brand -->
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-gray-800 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        {{ __('messages.app_title') }}
                    </a>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->is('/') ? 'text-blue-600 dark:text-blue-400 font-semibold' : '' }}">
                        {{ __('messages.home') }}
                    </a>
                    <a href="/tasks" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->is('tasks*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : '' }}">
                        {{ __('messages.tasks') }}
                    </a>
                    <a href="/projects" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->is('projects*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : '' }}">
                        {{ __('messages.projects') }}
                    </a>
                    <a href="/stats" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->is('stats*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : '' }}">
                        {{ __('messages.statistics') }}
                    </a>
                </div>
                
                <!-- Theme Toggle & Language -->
                <div class="flex items-center space-x-4">
                    <!-- Language Toggle -->
                    <div class="relative">
                        <button onclick="toggleLanguage()" class="flex items-center space-x-1 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
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
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button onclick="toggleMobileMenu()" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div id="mobile-menu" class="md:hidden hidden border-t border-gray-200 dark:border-gray-700">
                <div class="py-2 space-y-1">
                    <a href="/" class="block px-3 py-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->is('/') ? 'text-blue-600 dark:text-blue-400 font-semibold' : '' }}">
                        {{ __('messages.home') }}
                    </a>
                    <a href="/tasks" class="block px-3 py-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->is('tasks*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : '' }}">
                        {{ __('messages.tasks') }}
                    </a>
                    <a href="/projects" class="block px-3 py-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->is('projects*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : '' }}">
                        {{ __('messages.projects') }}
                    </a>
                    <a href="/stats" class="block px-3 py-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->is('stats*') ? 'text-blue-600 dark:text-blue-400 font-semibold' : '' }}">
                        {{ __('messages.statistics') }}
                    </a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        @yield('content')
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
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }
        
        // Language toggle
        function toggleLanguage() {
            const currentLang = '{{ app()->getLocale() }}';
            const newLang = currentLang === 'pt' ? 'en' : 'pt';
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
        }
        
        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            const themeIcon = document.getElementById('theme-icon');
            
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
                themeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>';
            }
        });
    </script>
</body>
</html>