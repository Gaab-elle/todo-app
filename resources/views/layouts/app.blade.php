<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'To-Do App Laravel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen transition-all duration-500 relative overflow-x-hidden">
    {{-- Background layers para light e dark mode --}}
    <div class="fixed inset-0 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:opacity-0 transition-opacity duration-500"></div>
    <div class="fixed inset-0 bg-gradient-to-br from-gray-900 via-slate-800 to-gray-900 opacity-0 dark:opacity-100 transition-opacity duration-500"></div>
    
    {{-- Conteúdo principal --}}
    <div class="relative z-10 min-h-screen">
        <div class="container mx-auto px-4 py-8">
            @yield('content')
        </div>
    </div>

    {{-- Notificações de sucesso --}}
    @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition 
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed top-4 right-4 bg-green-500 dark:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif

    {{-- Script para Dark Mode --}}
    <script>
        function toggleDarkMode() {
            const html = document.documentElement;
            
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('darkMode', 'false');
                console.log('Dark mode OFF');
            } else {
                html.classList.add('dark');
                localStorage.setItem('darkMode', 'true');
                console.log('Dark mode ON');
            }
        }

        // Aplicar dark mode salvo ou preferência do sistema
        function initDarkMode() {
            const savedMode = localStorage.getItem('darkMode');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (savedMode === 'true' || (!savedMode && prefersDark)) {
                document.documentElement.classList.add('dark');
                console.log('Dark mode aplicado no carregamento');
            } else {
                document.documentElement.classList.remove('dark');
                console.log('Light mode aplicado no carregamento');
            }
        }

        // Executar imediatamente para evitar flash
        initDarkMode();
        
        // Executar novamente quando o DOM carregar (garantia)
        document.addEventListener('DOMContentLoaded', initDarkMode);
    </script>
</body>
</html>