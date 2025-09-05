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
    
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
    
    @stack('styles')
    
    <!-- Translations for JavaScript -->
    <script>
        window.translations = {
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
            'high': '{{ __("messages.high") }}',
            'medium': '{{ __("messages.medium") }}',
            'low': '{{ __("messages.low") }}',
            'all': '{{ __("messages.all") }}',
            'pending': '{{ __("messages.pending") }}',
            'completed': '{{ __("messages.completed") }}',
            'title': '{{ __("messages.title") }}',
            'description': '{{ __("messages.description") }}',
            'priority': '{{ __("messages.priority") }}',
            'dueDate': '{{ __("messages.due_date") }}'
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
            background-color: #ffffff;
            color: #111827;
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
<body class="dark:bg-gray-900 dark:text-white light:bg-white light:text-gray-900 min-h-screen antialiased transition-colors duration-300">
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
</body>
</html>