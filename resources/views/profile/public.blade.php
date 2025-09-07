@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-transparent">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Profile Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-6">
                    <!-- Avatar -->
                    <div class="relative">
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-gray-300 dark:border-gray-600">
                            @if($user->avatar)
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                    <span class="text-white text-4xl font-bold">{{ $user->initials }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- User Info -->
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                        <p class="text-xl text-gray-600 dark:text-gray-400">@{{ $user->username ?? 'username' }}</p>
                        
                        @php
                            // Verificar se o perfil tem informações básicas configuradas
                            $hasBasicInfo = $user->bio || $user->location || $user->website || $user->linkedin || $user->twitter || $user->github_username;
                            $hasSkills = $user->skills && is_array($user->skills) && count($user->skills) > 0;
                            $isProfileConfigured = $hasBasicInfo || $hasSkills;
                            $isOwnProfile = auth()->check() && auth()->id() == $user->id;
                        @endphp
                        
                        @if($user->bio)
                            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $user->bio }}</p>
                        @endif
                        
                        @if($isOwnProfile && !$isProfileConfigured)
                            <!-- Profile Not Configured Message - Only for own profile -->
                            <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <div>
                                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                            {{ __('messages.profile_not_configured') }}
                                        </h3>
                                        <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                                            {{ __('messages.profile_not_configured_description') }}
                                        </p>
                                        <a href="{{ route('profile.settings') }}" class="inline-flex items-center mt-2 text-sm font-medium text-yellow-800 dark:text-yellow-200 hover:text-yellow-900 dark:hover:text-yellow-100">
                                            {{ __('messages.configure_profile') }}
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Social Links -->
                        <div class="flex items-center space-x-4 mt-4">
                                @if($user->location)
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $user->location }}
                                    </div>
                                @endif
                            
                            @if($user->website)
                                <a href="{{ $user->website }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            @endif
                            
                            @if($user->linkedin)
                                <a href="{{ $user->linkedin }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                            @endif
                            
                            @if($user->github_username)
                                <a href="https://github.com/{{ $user->github_username }}" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                </a>
                            @endif
                            </div>
                    </div>
                </div>
                
                <!-- Profile Stats -->
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->projects->count() }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Projetos</div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- About Me Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">👋 Olá, Mundo! Sou {{ $user->name }}</h2>
                    <div class="space-y-4">
                        @if($user->bio)
                            <p class="text-lg text-gray-600 dark:text-gray-400">{{ $user->bio }}</p>
                        @endif
                        
                        @if($user->skills && is_array($user->skills) && count($user->skills) > 0)
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Foco:</span>
                                <span class="text-lg font-semibold text-blue-600 dark:text-blue-400">
                                    {{ implode(' | ', array_slice($user->skills, 0, 3)) }}
                                </span>
                            </div>
                        @endif
                        
                        @if(!$user->bio && $isOwnProfile)
                            <p class="text-gray-600 dark:text-gray-400 italic">
                                Adicione uma biografia nas configurações para personalizar seu perfil.
                            </p>
                        @elseif(!$user->bio)
                            <p class="text-gray-600 dark:text-gray-400 italic">
                                Este desenvolvedor ainda não adicionou uma biografia.
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Technologies and Tools Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Tecnologias & Ferramentas</h2>
                    
                    @if($user->skills && is_array($user->skills) && count($user->skills) > 0)
                        <!-- Skills from user profile -->
                        <div class="flex flex-wrap gap-3">
                            @foreach($user->skills ?? [] as $skill)
                                @php
                                    $colors = [
                                        'PHP' => 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200',
                                        'LARAVEL' => 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200',
                                        'PYTHON' => 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
                                        'JAVASCRIPT' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
                                        'REACT' => 'bg-cyan-100 dark:bg-cyan-900 text-cyan-800 dark:text-cyan-200',
                                        'VUE' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                                        'MYSQL' => 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200',
                                        'POSTGRESQL' => 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
                                        'GIT' => 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200',
                                        'LINUX' => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200',
                                        'CSS' => 'bg-pink-100 dark:bg-pink-900 text-pink-800 dark:text-pink-200',
                                        'HTML' => 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200',
                                    ];
                                    $colorClass = $colors[strtoupper($skill)] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200';
                                @endphp
                                <span class="px-3 py-2 {{ $colorClass }} rounded-lg text-sm font-medium">{{ strtoupper($skill) }}</span>
                            @endforeach
                        </div>
                    @else
                        @if($isOwnProfile)
                            <p class="text-gray-600 dark:text-gray-400 italic">
                                Adicione suas tecnologias e ferramentas nas configurações para mostrar suas habilidades.
                            </p>
                        @else
                            <p class="text-gray-600 dark:text-gray-400 italic">
                                Este desenvolvedor ainda não adicionou suas tecnologias.
                            </p>
                        @endif
                    @endif
                </div>

                @if($projects && $projects->count() > 0)
                <!-- Featured Projects Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Projetos em Destaque</h2>
                    
                    <!-- Project Cards -->
                    <div class="space-y-6">
                        @foreach($projects as $project)
                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-6 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $project->name }}</h3>
                                        @if($project->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $project->description }}</p>
                                        @endif
                                    </div>
                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs rounded-full">
                                        {{ $project->is_public ? 'Público' : 'Privado' }}
                                    </span>
                                </div>
                                @if($project->technologies)
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <strong>Tecnologias:</strong> {{ $project->technologies }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                <!-- Default Projects Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Projetos em Destaque</h2>
                    
                    <!-- Project Cards -->
                    <div class="space-y-6">
                        <!-- Nerdino Project -->
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Nerdino - Gerenciador de Tarefas para Devs</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        Plataforma desenvolvida especialmente para desenvolvedores, focada em organização, 
                                        produtividade e acompanhamento de projetos.
                                    </p>
                                </div>
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs rounded-full">Público</span>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Tecnologias:</strong> PHP, Laravel, Vue.js, MySQL
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Características:</strong> Kanban interativo, integração com GitHub, gestão de prazos
                                </p>
                            </div>
                        </div>

                        <!-- YggdraGroup Project -->
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">YggdraGroup - Site Institucional</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        Portal da empresa YggdraGroup, unindo identidade de desenvolvimento de software 
                                        e suporte técnico com único.
                                    </p>
                                </div>
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs rounded-full">Público</span>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Tecnologias:</strong> React, Node.js, CSS3, Design Responsivo
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Características:</strong> Design moderno, otimização SEO, interface intuitiva
                                </p>
                            </div>
                        </div>

                        <!-- Sistema OS Project -->
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sistema de SO para Técnicos de Hardware</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        Plataforma para controle de ordens de serviço, ideal para assistências técnicas 
                                        e gestão de atendimentos.
                                    </p>
                                </div>
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs rounded-full">Público</span>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Tecnologias:</strong> PHP, Laravel, Bootstrap, MySQL
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Características:</strong> Autenticação robusta, Eloquent ORM, Blade templates, validações automáticas, controle de estoque, gestão de clientes
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                
                
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        @if($user->github_username)
                <!-- GitHub Statistics -->                                                                                                                                                                                                                                                                                                                                                            
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        GitHub - @{{ $user->github_username }}
                    </h3>
                    
                    @if($githubStats)
                    <!-- GitHub Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $githubStats['total_repos'] ?? 0 }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Repositórios</div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $githubStats['stars'] ?? 0 }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Stars</div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $githubStats['forks'] ?? 0 }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Forks</div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $githubStats['watchers'] ?? 0 }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Watchers</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($githubLanguages && is_array($githubLanguages) && count($githubLanguages) > 0)
                    <!-- Most Used Languages -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Linguagens de Programação</h4>
                        <div class="space-y-2">
                            @php
                                $totalBytes = array_sum($githubLanguages ?? []);
                                $topLanguages = array_slice($githubLanguages ?? [], 0, 5, true);
                            @endphp
                            @foreach($topLanguages as $language => $bytes)
                                @php
                                    $percentage = $totalBytes > 0 ? round(($bytes / $totalBytes) * 100, 1) : 0;
                                @endphp
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-600 dark:text-gray-400">{{ $language }}</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $percentage }}%</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    @if($githubRepos && is_array($githubRepos) && count($githubRepos) > 0)
                    <!-- Recent Repositories -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Repositórios Recentes</h4>
                        <div class="space-y-2">
                            @foreach(array_slice($githubRepos ?? [], 0, 3) as $repo)
                                <div class="flex items-center justify-between text-xs">
                                    <a href="{{ $repo['html_url'] }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $repo['name'] }}
                                    </a>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-gray-500">⭐ {{ $repo['stargazers_count'] }}</span>
                                        <span class="text-gray-500">🍴 {{ $repo['forks_count'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <div class="mt-4 text-center">
                        <a href="https://github.com/{{ $user->github_username }}" target="_blank" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                            Ver no GitHub
                        </a>
                    </div>
                </div>
                @endif

                <!-- Let's Talk Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Vamos Conversar?
                    </h3>
                    
                    <div class="space-y-3">
                        <a href="{{ $user->linkedin ?? '#' }}" target="_blank" class="flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            LINKEDIN
                        </a>
                        
                        <a href="mailto:{{ $user->email }}" class="flex items-center justify-center w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            GMAIL
                        </a>
                        
                        <a href="https://wa.me/5511999999999" target="_blank" class="flex items-center justify-center w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            WHATSAPP
                        </a>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <div class="flex items-center justify-center text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-1 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            Profile Views 7,202
                        </div>
                    </div>
                </div>

                <!-- Quote Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 text-center">
                    <blockquote class="text-gray-600 dark:text-gray-400 italic">
                        "A tecnologia é melhor quando aproxima as pessoas"
                    </blockquote>
                    <cite class="text-sm text-gray-500 dark:text-gray-500 mt-2 block">- Matt Mullenweg</cite>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection