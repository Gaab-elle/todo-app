@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 light:bg-gradient-to-br light:from-gray-100 light:via-gray-200 light:to-gray-300 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Navigation -->
        <nav class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home.index') }}" class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>{{ __('messages.home') }}</span>
                    </a>
                    <a href="{{ route('projects.index') }}" class="flex items-center space-x-2 text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span>{{ __('messages.projects') }}</span>
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    <!-- Theme Toggle -->
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-400">{{ __('messages.theme') }}:</span>
                        <button class="theme-toggle bg-gray-700 hover:bg-gray-600 p-2 rounded-lg transition-all duration-200" title="{{ __('messages.toggle_theme') }}">
                            <svg class="w-5 h-5 text-white theme-icon-dark" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                            <svg class="w-5 h-5 text-white theme-icon-light hidden" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Language Switcher -->
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-400">{{ __('messages.language') }}:</span>
                        @foreach($availableLocales as $locale)
                            <a href="{{ route('locale.switch', $locale) }}" class="px-3 py-1 text-sm rounded {{ $currentLocale === $locale ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                {{ strtoupper($locale) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </nav>

        <!-- Header -->
        <div class="mb-8 animate-slide-up" style="animation-delay: 0.1s;">
            <h1 class="text-5xl font-bold dark:bg-gradient-to-r dark:from-white dark:via-blue-100 dark:to-purple-200 light:bg-gradient-to-r light:from-gray-800 light:via-gray-600 light:to-gray-700 bg-clip-text text-transparent mb-4 animate-float">{{ __('messages.create_project') }}</h1>
            <p class="dark:text-gray-300 light:text-gray-600 text-lg font-medium">{{ __('messages.create_new_project_description') }}</p>
        </div>

        <!-- Create Project Form -->
        <div class="bg-gray-700 rounded-2xl border border-gray-600 p-8 shadow-lg hover:shadow-xl transition-all duration-400 animate-slide-up" style="animation-delay: 0.2s;">
            <form action="{{ route('projects.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-gray-200 mb-3">
                            {{ __('messages.project_name') }} <span class="text-red-400">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               required
                               class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                               placeholder="{{ __('messages.enter_project_name') }}"
                               value="{{ old('name') }}">
                        @error('name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-200 mb-3">
                            {{ __('messages.project_description') }}
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30 resize-none"
                                  placeholder="{{ __('messages.describe_project') }}">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="color" class="block text-sm font-semibold text-gray-200 mb-3">
                            {{ __('messages.project_color') }} <span class="text-red-400">*</span>
                        </label>
                        <div class="flex items-center space-x-3">
                            <input type="color" 
                                   id="color" 
                                   name="color" 
                                   required
                                   value="{{ old('color', '#3B82F6') }}"
                                   class="w-16 h-12 bg-gray-800/50 border border-gray-600/50 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                            <input type="text" 
                                   id="color-text" 
                                   value="{{ old('color', '#3B82F6') }}"
                                   class="flex-1 px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                                   placeholder="#3B82F6"
                                   pattern="^#[0-9A-Fa-f]{6}$">
                        </div>
                        @error('color')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="icon" class="block text-sm font-semibold text-gray-200 mb-3">
                            {{ __('messages.project_icon') }}
                        </label>
                        <input type="text" 
                               id="icon" 
                               name="icon"
                               class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                               placeholder="📁 ou nome do ícone"
                               value="{{ old('icon') }}">
                        <p class="mt-2 text-xs text-gray-400">{{ __('messages.icon_help') }}</p>
                        @error('icon')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ route('projects.index') }}" 
                       class="px-6 py-3 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500/50 focus:ring-offset-2 focus:ring-offset-transparent hover:scale-105 transform">
                        {{ __('messages.cancel') }}
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-primary hover:shadow-glow text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2 focus:ring-offset-transparent hover:scale-105 transform">
                        {{ __('messages.create_project') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorInput = document.getElementById('color');
    const colorText = document.getElementById('color-text');
    
    colorInput.addEventListener('input', function() {
        colorText.value = this.value;
    });
    
    colorText.addEventListener('input', function() {
        if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
            colorInput.value = this.value;
        }
    });
});
</script>
@endsection
