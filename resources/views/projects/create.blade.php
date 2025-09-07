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

                <!-- Development-specific fields -->
                <div class="border-t border-gray-600/50 pt-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-200 mb-4">{{ __('messages.development_details') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Project Type -->
                        <div>
                            <label for="project_type" class="block text-sm font-semibold text-gray-200 mb-3">
                                {{ __('messages.project_type') }}
                            </label>
                            <select id="project_type" 
                                    name="project_type" 
                                    class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30">
                                <option value="">{{ __('messages.select_project_type') }}</option>
                                <option value="frontend" {{ old('project_type') == 'frontend' ? 'selected' : '' }}>{{ __('messages.frontend') }}</option>
                                <option value="backend" {{ old('project_type') == 'backend' ? 'selected' : '' }}>{{ __('messages.backend') }}</option>
                                <option value="mobile" {{ old('project_type') == 'mobile' ? 'selected' : '' }}>{{ __('messages.mobile') }}</option>
                                <option value="fullstack" {{ old('project_type') == 'fullstack' ? 'selected' : '' }}>{{ __('messages.fullstack') }}</option>
                                <option value="api" {{ old('project_type') == 'api' ? 'selected' : '' }}>{{ __('messages.api') }}</option>
                                <option value="library" {{ old('project_type') == 'library' ? 'selected' : '' }}>{{ __('messages.library') }}</option>
                                <option value="framework" {{ old('project_type') == 'framework' ? 'selected' : '' }}>{{ __('messages.framework') }}</option>
                            </select>
                        </div>

                        <!-- Development Status -->
                        <div>
                            <label for="development_status" class="block text-sm font-semibold text-gray-200 mb-3">
                                {{ __('messages.development_status') }}
                            </label>
                            <select id="development_status" 
                                    name="development_status" 
                                    class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30">
                                <option value="planning" {{ old('development_status', 'planning') == 'planning' ? 'selected' : '' }}>{{ __('messages.planning') }}</option>
                                <option value="active" {{ old('development_status') == 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                                <option value="paused" {{ old('development_status') == 'paused' ? 'selected' : '' }}>{{ __('messages.paused') }}</option>
                                <option value="completed" {{ old('development_status') == 'completed' ? 'selected' : '' }}>{{ __('messages.completed') }}</option>
                            </select>
                        </div>

                        <!-- Repository URL -->
                        <div class="md:col-span-2">
                            <label for="repository_url" class="block text-sm font-semibold text-gray-200 mb-3">
                                {{ __('messages.repository_url') }}
                            </label>
                            <input type="url" 
                                   id="repository_url" 
                                   name="repository_url" 
                                   class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                                   placeholder="https://github.com/username/project"
                                   value="{{ old('repository_url') }}">
                        </div>

                        <!-- Programming Languages -->
                        <div>
                            <label for="programming_languages" class="block text-sm font-semibold text-gray-200 mb-3">
                                {{ __('messages.programming_languages') }}
                            </label>
                            <div id="languages-container" class="space-y-2">
                                <div class="flex space-x-2">
                                    <input type="text" 
                                           name="programming_languages[]" 
                                           class="flex-1 px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                                           placeholder="Ex: PHP, JavaScript, Python...">
                                    <button type="button" onclick="addLanguageField()" class="px-4 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Technologies Used -->
                        <div>
                            <label for="technologies_used" class="block text-sm font-semibold text-gray-200 mb-3">
                                {{ __('messages.technologies_used') }}
                            </label>
                            <div id="technologies-container" class="space-y-2">
                                <div class="flex space-x-2">
                                    <input type="text" 
                                           name="technologies_used[]" 
                                           class="flex-1 px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                                           placeholder="Ex: Laravel, Vue.js, MySQL...">
                                    <button type="button" onclick="addTechnologyField()" class="px-4 py-3 bg-green-600 hover:bg-green-500 text-white rounded-xl transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Time Spent -->
                        <div>
                            <label for="time_spent" class="block text-sm font-semibold text-gray-200 mb-3">
                                {{ __('messages.time_spent') }} (minutos)
                            </label>
                            <input type="number" 
                                   id="time_spent" 
                                   name="time_spent" 
                                   min="0"
                                   class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                                   placeholder="0"
                                   value="{{ old('time_spent', 0) }}">
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-semibold text-gray-200 mb-3">
                                {{ __('messages.project_category') }}
                            </label>
                            <input type="text" 
                                   id="category" 
                                   name="category" 
                                   class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                                   placeholder="Ex: E-commerce, Blog, API..."
                                   value="{{ old('category') }}">
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-semibold text-gray-200 mb-3">
                                Data de Início
                            </label>
                            <input type="date" 
                                   id="start_date" 
                                   name="start_date" 
                                   class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                                   value="{{ old('start_date') }}">
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-sm font-semibold text-gray-200 mb-3">
                                Data de Conclusão
                            </label>
                            <input type="date" 
                                   id="end_date" 
                                   name="end_date" 
                                   class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                                   value="{{ old('end_date') }}">
                        </div>
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

// Funções para campos dinâmicos
function addLanguageField() {
    const container = document.getElementById('languages-container');
    const newField = document.createElement('div');
    newField.className = 'flex space-x-2';
    newField.innerHTML = `
        <input type="text" 
               name="programming_languages[]" 
               class="flex-1 px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
               placeholder="Ex: PHP, JavaScript, Python...">
        <button type="button" onclick="removeField(this)" class="px-4 py-3 bg-red-600 hover:bg-red-500 text-white rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    container.appendChild(newField);
}

function addTechnologyField() {
    const container = document.getElementById('technologies-container');
    const newField = document.createElement('div');
    newField.className = 'flex space-x-2';
    newField.innerHTML = `
        <input type="text" 
               name="technologies_used[]" 
               class="flex-1 px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
               placeholder="Ex: Laravel, Vue.js, MySQL...">
        <button type="button" onclick="removeField(this)" class="px-4 py-3 bg-red-600 hover:bg-red-500 text-white rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    container.appendChild(newField);
}

function removeField(button) {
    button.parentElement.remove();
}
</script>
@endsection
