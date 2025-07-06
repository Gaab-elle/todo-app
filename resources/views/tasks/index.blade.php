@extends('layouts.app')

@section('title', 'Minhas Tarefas')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <div class="flex items-center justify-center gap-4 mb-6">
            <div class="p-4 rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-600 shadow-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            
            <h1 class="text-5xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">
                Minhas Tarefas
            </h1>
            
            <!-- Dark Mode Toggle -->
            <button id="dark-mode-toggle" 
                    onclick="toggleDarkMode()" 
                    class="p-3 rounded-2xl transition-all duration-300 hover:scale-110 bg-slate-800 dark:bg-yellow-400 text-yellow-400 dark:text-slate-900 shadow-lg hover:shadow-xl">
                <!-- Sun Icon (mostrado no dark mode) -->
                <svg class="w-6 h-6 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <!-- Moon Icon (mostrado no light mode) -->
                <svg class="w-6 h-6 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </button>
        </div>
        
        <!-- Stats -->
        <div class="flex justify-center gap-6 flex-wrap">
            <div class="px-6 py-3 rounded-xl bg-white/70 dark:bg-white/10 backdrop-blur-sm shadow-lg border border-white/20 dark:border-white/10">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Total:</span>
                <span class="text-lg font-bold text-gray-800 dark:text-white ml-1">{{ $stats['total'] }}</span>
            </div>
            <div class="px-6 py-3 rounded-xl bg-green-100/80 dark:bg-green-500/20 backdrop-blur-sm shadow-lg border border-green-200/50 dark:border-green-500/20">
                <span class="text-sm font-medium text-green-600 dark:text-green-300">Concluídas:</span>
                <span class="text-lg font-bold text-green-800 dark:text-green-200 ml-1">{{ $stats['completed'] }}</span>
            </div>
            <div class="px-6 py-3 rounded-xl bg-orange-100/80 dark:bg-orange-500/20 backdrop-blur-sm shadow-lg border border-orange-200/50 dark:border-orange-500/20">
                <span class="text-sm font-medium text-orange-600 dark:text-orange-300">Pendentes:</span>
                <span class="text-lg font-bold text-orange-800 dark:text-orange-200 ml-1">{{ $stats['pending'] }}</span>
            </div>
            <div class="px-6 py-3 rounded-xl bg-red-100/80 dark:bg-red-500/20 backdrop-blur-sm shadow-lg border border-red-200/50 dark:border-red-500/20">
                <span class="text-sm font-medium text-red-600 dark:text-red-300">Alta Prioridade:</span>
                <span class="text-lg font-bold text-red-800 dark:text-red-200 ml-1">{{ $stats['high_priority'] }}</span>
            </div>
        </div>
    </div>

    <!-- Add Task Form -->
    <div class="bg-white/80 dark:bg-white/5 backdrop-blur-sm rounded-3xl shadow-2xl p-8 mb-8 border border-white/50 dark:border-white/10">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Adicionar Nova Tarefa</h2>
        
        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Título</label>
                    <input type="text" name="title" id="title" required
                           class="w-full p-4 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:outline-none transition-colors"
                           placeholder="Digite o título da tarefa...">
                    @error('title')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Prioridade</label>
                    <select name="priority" id="priority" required
                            class="w-full p-4 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-indigo-500 dark:focus:border-indigo-400 focus:outline-none transition-colors">
                        <option value="low">Baixa</option>
                        <option value="medium" selected>Média</option>
                        <option value="high">Alta</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Descrição</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full p-4 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-indigo-500 dark:focus:border-indigo-400 focus:outline-none transition-colors"
                          placeholder="Descreva sua tarefa..."></textarea>
            </div>
            
            <div>
                <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data de Vencimento</label>
                <input type="date" name="due_date" id="due_date"
                       class="w-full p-4 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-indigo-500 dark:focus:border-indigo-400 focus:outline-none transition-colors">
            </div>
            
            <button type="submit"
                    class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-4 px-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                Criar Tarefa
            </button>
        </form>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap justify-center gap-3 mb-8">
        @php
            $filters = [
                'all' => 'Todas',
                'pending' => 'Pendentes',
                'completed' => 'Concluídas',
                'high' => 'Alta Prioridade',
                'medium' => 'Média Prioridade',
                'low' => 'Baixa Prioridade'
            ];
        @endphp
        
        @foreach($filters as $key => $label)
            <a href="{{ route('tasks.index', ['filter' => $key]) }}"
               class="px-4 py-2 rounded-xl transition-all duration-300 {{ 
                   $filter === $key 
                       ? 'bg-indigo-500 text-white shadow-lg scale-105' 
                       : 'bg-white/70 dark:bg-white/10 text-gray-600 dark:text-gray-300 hover:bg-white/90 dark:hover:bg-white/20 hover:scale-105 border border-white/50 dark:border-white/10'
               }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <!-- Tasks List -->
    <div class="space-y-4">
        @forelse($tasks as $task)
            <div class="group bg-white/80 dark:bg-white/5 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 dark:border-white/10 p-6 hover:shadow-xl dark:hover:shadow-2xl transition-all duration-300 hover:scale-[1.02]">
                <div class="flex items-start gap-4">
                    <!-- Toggle Button -->
                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="flex-shrink-0 w-6 h-6 rounded-full border-2 transition-all duration-300 flex items-center justify-center mt-1 {{ 
                                    $task->completed 
                                        ? 'bg-green-500 border-green-500 scale-110' 
                                        : 'border-gray-300 dark:border-gray-500 hover:border-green-500 dark:hover:border-green-400'
                                }}">
                            @if($task->completed)
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @endif
                        </button>
                    </form>
                    
                    <!-- Task Content -->
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="font-semibold text-lg {{ $task->completed ? 'line-through text-gray-500 dark:text-gray-400' : 'text-gray-800 dark:text-white' }}">
                                {{ $task->title }}
                            </h3>
                            <span class="px-3 py-1 rounded-full text-xs font-medium border {{ 
                                $task->priority === 'high' ? 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 border-red-200 dark:border-red-800' :
                                ($task->priority === 'medium' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800' :
                                'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border-green-200 dark:border-green-800')
                            }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        
                        @if($task->description)
                            <p class="text-gray-600 dark:text-gray-300 mb-2 {{ $task->completed ? 'line-through' : '' }}">
                                {{ $task->description }}
                            </p>
                        @endif
                        
                        <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                            <span>Criada em: {{ $task->created_at->format('d/m/Y H:i') }}</span>
                            @if($task->due_date)
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Vence em: {{ $task->due_date->format('d/m/Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')"
                                    class="p-2 rounded-xl text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="text-lg text-gray-500 dark:text-gray-400">Nenhuma tarefa encontrada</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Crie sua primeira tarefa acima!</p>
            </div>
        @endforelse
    </div>
    
    <!-- Progress Bar -->
    @if($stats['total'] > 0)
        <div class="mt-12 bg-white/80 dark:bg-white/5 backdrop-blur-sm rounded-2xl shadow-lg p-6 border border-white/50 dark:border-white/10">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Progresso Geral</span>
                <span class="text-sm font-bold text-gray-800 dark:text-white">
                    {{ round(($stats['completed'] / $stats['total']) * 100) }}%
                </span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-500" 
                     style="width: {{ ($stats['completed'] / $stats['total']) * 100 }}%"></div>
            </div>
            <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-3">
                {{ $stats['completed'] }} de {{ $stats['total'] }} tarefas concluídas
            </p>
            
            @if($stats['completed'] === $stats['total'])
                <div class="text-center mt-4">
                    <span class="text-2xl">🎉</span>
                    <p class="text-green-600 dark:text-green-400 font-semibold">Parabéns! Todas as tarefas concluídas!</p>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection