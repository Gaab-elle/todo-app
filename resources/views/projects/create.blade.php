@extends('layouts.app')

@section('content')
<div class="min-h-screen dark:bg-gradient-to-br dark:from-slate-900 dark:via-purple-900 dark:to-slate-900 light:bg-gradient-to-br light:from-gray-100 light:via-gray-200 light:to-gray-300 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">

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
