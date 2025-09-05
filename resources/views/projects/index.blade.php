@extends('layouts.app')

@section('content')
<div class="min-h-screen dark:bg-gradient-to-br dark:from-slate-900 dark:via-purple-900 dark:to-slate-900 light:bg-gradient-to-br light:from-gray-100 light:via-gray-200 light:to-gray-300 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="mb-8 animate-slide-up" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-5xl font-bold dark:bg-gradient-to-r dark:from-white dark:via-blue-100 dark:to-purple-200 light:bg-gradient-to-r light:from-gray-800 light:via-gray-600 light:to-gray-700 bg-clip-text text-transparent mb-4 animate-float">{{ __('messages.projects') }}</h1>
                    <p class="dark:text-gray-300 light:text-gray-600 text-lg font-medium">{{ __('messages.manage_your_projects') }}</p>
                </div>
                <a href="{{ route('projects.create') }}" class="px-6 py-3 bg-gradient-primary hover:shadow-glow text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2 focus:ring-offset-transparent hover:scale-105 transform">
                    {{ __('messages.create_project') }}
                </a>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
                <div class="bg-gray-700 rounded-2xl border border-gray-600 p-6 shadow-lg hover:shadow-xl transition-all duration-400 animate-slide-up group hover:scale-[1.02] transform" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            @if($project->icon)
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white text-xl" style="background-color: {{ $project->color }};">
                                    {{ $project->icon }}
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white" style="background-color: {{ $project->color }};">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-xl font-semibold text-white group-hover:text-blue-100 transition-colors duration-300">
                                        {{ $project->name }}
                                    </h3>
                                    <button onclick="toggleFavorite({{ $project->id }})" 
                                            class="favorite-btn p-1 transition-all duration-200 {{ $project->is_favorite ? 'text-yellow-400' : 'text-gray-500 hover:text-yellow-300' }}" 
                                            title="{{ $project->is_favorite ? __('messages.unfavorite') : __('messages.favorite') }}">
                                        <svg class="w-4 h-4" fill="{{ $project->is_favorite ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-sm text-gray-400">{{ $project->tasks_count }} {{ __('messages.tasks') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('projects.edit', $project) }}" class="p-2 text-gray-400 hover:text-blue-400 transition-colors duration-200" title="{{ __('messages.edit_project') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-400 transition-colors duration-200" title="{{ __('messages.delete_project') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    @if($project->description)
                        <p class="text-gray-300 mb-4 leading-relaxed">{{ $project->description }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-400">{{ __('messages.created') }}:</span>
                            <span class="text-xs text-gray-300">{{ $project->created_at->format('d/m/Y') }}</span>
                        </div>
                        <a href="{{ route('projects.show', $project) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            {{ __('messages.view_details') }}
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-gray-700 rounded-2xl border border-gray-600 p-12 shadow-lg text-center">
                        <div class="text-gray-600 text-lg mb-6">
                            <svg class="mx-auto h-20 w-20 mb-6 animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('messages.no_projects') }}</h3>
                        <p class="text-gray-700 text-lg mb-6">{{ __('messages.no_projects_description') }}</p>
                        <a href="{{ route('projects.create') }}" class="px-6 py-3 bg-gradient-primary hover:shadow-glow text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2 focus:ring-offset-transparent hover:scale-105 transform">
                            {{ __('messages.create_first_project') }}
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function toggleFavorite(projectId) {
    console.log('Toggling favorite for project:', projectId);
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        showNotification('Erro de segurança. Recarregue a página.', 'error');
        return;
    }

    console.log('CSRF token found:', csrfToken.getAttribute('content'));

    fetch(`/projects/${projectId}/toggle-favorite`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Find the button for this project
            const button = document.querySelector(`button[onclick="toggleFavorite(${projectId})"]`);
            const svg = button.querySelector('svg');
            
            if (data.is_favorite) {
                // Make it favorite (yellow, filled)
                button.className = button.className.replace('text-gray-500 hover:text-yellow-300', 'text-yellow-400');
                svg.setAttribute('fill', 'currentColor');
                button.setAttribute('title', '{{ __("messages.unfavorite") }}');
            } else {
                // Make it not favorite (gray, outline)
                button.className = button.className.replace('text-yellow-400', 'text-gray-500 hover:text-yellow-300');
                svg.setAttribute('fill', 'none');
                button.setAttribute('title', '{{ __("messages.favorite") }}');
            }
            
            // Show notification
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message || 'Erro ao atualizar favorito', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Erro de conexão. Tente novamente.', 'error');
    });
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}
</script>

<style>
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 12px 20px;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    z-index: 3000;
    transform: translateX(100%);
    transition: transform 0.3s ease;
}

.notification.show {
    transform: translateX(0);
}

.notification-success {
    background-color: #10b981;
}

.notification-error {
    background-color: #ef4444;
}

.notification-info {
    background-color: #3b82f6;
}

.favorite-btn:hover {
    transform: scale(1.1);
}
</style>
@endsection

