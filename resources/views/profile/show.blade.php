@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 px-8 sm:px-12 lg:px-16 xl:px-20">
    <div class="max-w-6xl mx-auto">

        <!-- Header -->
        <div class="mb-8 animate-slide-up" style="animation-delay: 0.1s;">
            <h1 class="text-5xl font-bold dark:bg-gradient-to-r dark:from-white dark:via-blue-100 dark:to-purple-200 light:bg-gradient-to-r light:from-gray-800 light:via-gray-600 light:to-gray-700 bg-clip-text text-transparent mb-4 animate-float">{{ __('messages.profile') }}</h1>
            <p class="dark:text-gray-300 light:text-gray-600 text-lg font-medium">{{ __('messages.profile_description') }}</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/30 rounded-xl text-green-100 text-sm animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-xl text-red-100 text-sm animate-fade-in">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <!-- Profile Information -->
            <div class="lg:col-span-4 space-y-8">
                <!-- User Info Card -->
                <div class="bg-gray-700 rounded-2xl border border-gray-600 p-8 shadow-lg hover:shadow-xl transition-all duration-400 animate-slide-up" style="animation-delay: 0.2s;">
                    <div class="flex items-center space-x-6">
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                            <p class="text-gray-400">{{ $user->email }}</p>
                            <p class="text-sm text-gray-500">{{ __('messages.member_since') }} {{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Settings Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                    <!-- Public Profile Settings -->
                    <div class="bg-gray-700 rounded-2xl border border-gray-600 p-8 shadow-lg hover:shadow-xl transition-all duration-400 animate-slide-up" style="animation-delay: 0.25s;">
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                            </svg>
                            {{ __('messages.public_profile') }}
                        </h3>

                        <div class="space-y-6">
                            <!-- Profile Visibility Toggle -->
                            <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg border border-gray-600">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">{{ __('messages.profile_settings') }}</h4>
                                    <p class="text-sm text-gray-400">
                                        @if($user->is_public)
                                            {{ __('messages.make_private') }} - Seu perfil está público
                                        @else
                                            {{ __('messages.make_public') }} - Seu perfil está privado
                                        @endif
                                    </p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_public" value="1" {{ $user->is_public ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-purple-600"></div>
                                </label>
                            </div>

                            <!-- Profile Type -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-200 mb-3">{{ __('messages.profile_type') }}</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="flex items-center p-3 bg-gray-800 rounded-lg border border-gray-600 cursor-pointer hover:bg-gray-750 transition-colors">
                                        <input type="radio" name="profile_type" value="professional" {{ $user->profile_type === 'professional' ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-4 h-4 border-2 border-gray-400 rounded-full peer-checked:border-purple-500 peer-checked:bg-purple-500 mr-3 flex items-center justify-center">
                                            <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100"></div>
                                        </div>
                                        <div>
                                            <div class="text-white font-medium">{{ __('messages.professional') }}</div>
                                            <div class="text-xs text-gray-400">Foco em carreira</div>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 bg-gray-800 rounded-lg border border-gray-600 cursor-pointer hover:bg-gray-750 transition-colors">
                                        <input type="radio" name="profile_type" value="personal" {{ $user->profile_type === 'personal' ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-4 h-4 border-2 border-gray-400 rounded-full peer-checked:border-purple-500 peer-checked:bg-purple-500 mr-3 flex items-center justify-center">
                                            <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100"></div>
                                        </div>
                                        <div>
                                            <div class="text-white font-medium">{{ __('messages.personal') }}</div>
                                            <div class="text-xs text-gray-400">Projetos pessoais</div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-sm font-semibold text-gray-200 mb-3">
                                    {{ __('messages.username') }}
                                    <span class="text-xs text-gray-400 ml-2">({{ __('messages.username_help') }})</span>
                                </label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-600 bg-gray-800 text-gray-300 text-sm">
                                        {{ url('/profile/') }}/
                                    </span>
                                    <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" 
                                           class="flex-1 px-4 py-2 bg-gray-800 border border-gray-600 rounded-r-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                           placeholder="seu-username">
                                </div>
                                @error('username')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bio -->
                            <div>
                                <label for="bio" class="block text-sm font-semibold text-gray-200 mb-3">
                                    {{ __('messages.bio') }}
                                    <span class="text-xs text-gray-400 ml-2">({{ __('messages.bio_help') }})</span>
                                </label>
                                <textarea id="bio" name="bio" rows="3" 
                                          class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                                          placeholder="Conte um pouco sobre você, seus projetos e interesses...">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Location and Website -->
                            <div class="space-y-4">
                                <div>
                                    <label for="location" class="block text-sm font-semibold text-gray-200 mb-3">{{ __('messages.location') }}</label>
                                    <input type="text" id="location" name="location" value="{{ old('location', $user->location) }}" 
                                           class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                           placeholder="São Paulo, Brasil">
                                    @error('location')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="website" class="block text-sm font-semibold text-gray-200 mb-3">{{ __('messages.website') }}</label>
                                    <input type="url" id="website" name="website" value="{{ old('website', $user->website) }}" 
                                           class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                           placeholder="https://seusite.com">
                                    @error('website')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Social Links -->
                            <div class="space-y-4">
                                <div>
                                    <label for="linkedin" class="block text-sm font-semibold text-gray-200 mb-3">{{ __('messages.linkedin') }}</label>
                                    <input type="text" id="linkedin" name="linkedin" value="{{ old('linkedin', $user->linkedin) }}" 
                                           class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                           placeholder="linkedin.com/in/seuperfil">
                                    @error('linkedin')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="twitter" class="block text-sm font-semibold text-gray-200 mb-3">{{ __('messages.twitter') }}</label>
                                    <input type="text" id="twitter" name="twitter" value="{{ old('twitter', $user->twitter) }}" 
                                           class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                           placeholder="@seuperfil">
                                    @error('twitter')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="github_username" class="block text-sm font-semibold text-gray-200 mb-3">{{ __('messages.github_username') }}</label>
                                    <input type="text" id="github_username" name="github_username" value="{{ old('github_username', $user->github_username) }}" 
                                           class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                           placeholder="seuperfil">
                                    @error('github_username')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Public Profile URL -->
                            @if($user->is_public && $user->username)
                                <div class="p-4 bg-green-900/20 border border-green-500/30 rounded-lg">
                                    <h4 class="text-green-400 font-semibold mb-2">{{ __('messages.public_profile_url') }}</h4>
                                    <div class="flex items-center space-x-3">
                                        <input type="text" value="{{ $user->public_profile_url }}" readonly 
                                               class="flex-1 px-3 py-2 bg-gray-800 border border-gray-600 rounded text-white text-sm">
                                        <button type="button" onclick="copyToClipboard('{{ $user->public_profile_url }}')" 
                                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded text-sm transition-colors">
                                            {{ __('messages.copy_url') }}
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Edit Profile Form -->
                <div class="bg-gray-700 rounded-2xl border border-gray-600 p-8 shadow-lg hover:shadow-xl transition-all duration-400 animate-slide-up" style="animation-delay: 0.3s;">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        {{ __('messages.edit_profile') }}
                    </h3>

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-200 mb-3">
                                    {{ __('messages.name') }} <span class="text-red-400">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       required
                                       class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                                       placeholder="{{ __('messages.enter_name') }}"
                                       value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-200 mb-3">
                                    {{ __('messages.email') }} <span class="text-red-400">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       required
                                       class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                                       placeholder="{{ __('messages.enter_email') }}"
                                       value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="border-t border-gray-600/50 pt-6">
                            <h4 class="text-lg font-semibold text-white mb-4">{{ __('messages.change_password') }}</h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-semibold text-gray-200 mb-3">
                                        {{ __('messages.current_password') }}
                                    </label>
                                    <input type="password" 
                                           id="current_password" 
                                           name="current_password"
                                           class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                                           placeholder="{{ __('messages.enter_current_password') }}">
                                    @error('current_password')
                                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="password" class="block text-sm font-semibold text-gray-200 mb-3">
                                            {{ __('messages.new_password') }}
                                        </label>
                                        <input type="password" 
                                               id="password" 
                                               name="password"
                                               class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                                               placeholder="{{ __('messages.enter_new_password') }}">
                                        @error('password')
                                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-200 mb-3">
                                            {{ __('messages.confirm_new_password') }}
                                        </label>
                                        <input type="password" 
                                               id="password_confirmation" 
                                               name="password_confirmation"
                                               class="w-full px-4 py-3 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400/50 focus:bg-gray-700/50 transition-all duration-300 hover:bg-gray-700/30"
                                               placeholder="{{ __('messages.confirm_new_password') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- Warning message -->
                            <div class="p-3 bg-yellow-900/20 border border-yellow-500/30 rounded-lg">
                                <p class="text-yellow-300 text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    {{ __('messages.delete_account_warning') }}
                                </p>
                            </div>
                            
                            <!-- Action buttons -->
                            <div class="flex justify-between items-center">
                                <button type="button" onclick="openDeleteModal()" 
                                        class="px-6 py-3 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:ring-offset-2 focus:ring-offset-transparent hover:scale-105 transform flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    {{ __('messages.delete_account') }}
                                </button>
                                <button type="submit" 
                                        class="px-8 py-3 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2 focus:ring-offset-transparent hover:scale-105 transform flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ __('messages.update_profile') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>

            <!-- Statistics Sidebar -->
            <div class="space-y-6">
                <!-- Avatar Card -->
                <div class="bg-gray-700 rounded-2xl border border-gray-600 p-6 shadow-lg animate-slide-up" style="animation-delay: 0.3s;">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('messages.avatar') }}
                    </h3>
                    
                    <!-- Avatar Display -->
                    <div class="flex flex-col items-center space-y-4">
                        <div class="relative group">
                            <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-600 group-hover:border-blue-400 transition-colors duration-300">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                        <span class="text-white text-3xl font-bold">{{ $user->initials }}</span>
                                    </div>
                                @endif
                            </div>
                            <!-- Upload Button Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer" onclick="document.getElementById('avatar-upload').click()">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Avatar Actions -->
                        <div class="w-full space-y-2">
                            <button type="button" onclick="document.getElementById('avatar-upload').click()" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-300 flex items-center justify-center text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                @if($user->avatar)
                                    {{ __('messages.edit_avatar') }}
                                @else
                                    {{ __('messages.upload_avatar') }}
                                @endif
                            </button>
                            @if($user->avatar)
                                <button type="button" onclick="removeAvatar()" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors duration-300 flex items-center justify-center text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    {{ __('messages.remove_avatar') }}
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Hidden File Input -->
                    <input type="file" id="avatar-upload" accept="image/*" class="hidden" onchange="uploadAvatar(this)">
                </div>

                <!-- Statistics Card -->
                <div class="bg-gray-700 rounded-2xl border border-gray-600 p-6 shadow-lg animate-slide-up" style="animation-delay: 0.4s;">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        {{ __('messages.statistics') }}
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">{{ __('messages.total_projects') }}</span>
                            <span class="text-white font-semibold">{{ $stats['total_projects'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">{{ __('messages.total_tasks') }}</span>
                            <span class="text-white font-semibold">{{ $stats['total_tasks'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">{{ __('messages.completed_tasks') }}</span>
                            <span class="text-green-400 font-semibold">{{ $stats['completed_tasks'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">{{ __('messages.pending_tasks') }}</span>
                            <span class="text-yellow-400 font-semibold">{{ $stats['pending_tasks'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">{{ __('messages.time_tracked') }}</span>
                            <span class="text-blue-400 font-semibold">{{ floor($stats['total_time_tracked'] / 60) }}h {{ $stats['total_time_tracked'] % 60 }}m</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-gray-800 rounded-2xl p-8 max-w-md w-full mx-4 border border-gray-600">
        <h3 class="text-xl font-bold text-white mb-4">{{ __('messages.delete_account') }}</h3>
        <p class="text-gray-300 mb-6">{{ __('messages.delete_account_confirmation') }}</p>
        
        <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
            @csrf
            @method('DELETE')
            
            <div>
                <label for="delete_password" class="block text-sm font-semibold text-gray-200 mb-2">
                    {{ __('messages.confirm_password') }}
                </label>
                <input type="password" 
                       id="delete_password" 
                       name="password" 
                       required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-400/50"
                       placeholder="{{ __('messages.enter_password_to_confirm') }}">
            </div>
            
            <div class="flex space-x-4">
                <button type="button" 
                        onclick="closeDeleteModal()" 
                        class="flex-1 px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white font-medium rounded-lg transition-colors">
                    {{ __('messages.cancel') }}
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-500 text-white font-medium rounded-lg transition-colors">
                    {{ __('messages.delete_account') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

// Avatar Upload Functions
function uploadAvatar(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file type
        if (!file.type.startsWith('image/')) {
            showNotification('{{ __("messages.validation_error") }}', 'error');
            return;
        }
        
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            showNotification('{{ __("messages.image_requirements") }}', 'error');
            return;
        }
        
        const formData = new FormData();
        formData.append('avatar', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        // Show loading state
        const uploadBtn = document.querySelector('button[onclick*="avatar-upload"]');
        const originalText = uploadBtn.innerHTML;
        uploadBtn.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Enviando...';
        uploadBtn.disabled = true;
        
        fetch('{{ route("avatar.upload") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update avatar display
                const avatarImg = document.querySelector('.w-20.h-20 img');
                const avatarDiv = document.querySelector('.w-20.h-20 div');
                
                if (avatarImg) {
                    avatarImg.src = data.avatar_url;
                } else if (avatarDiv) {
                    avatarDiv.innerHTML = `<img src="${data.avatar_url}" alt="{{ $user->name }}" class="w-full h-full object-cover">`;
                }
                
                // Show remove button if it doesn't exist
                const removeBtn = document.querySelector('button[onclick="removeAvatar()"]');
                if (!removeBtn) {
                    const uploadBtn = document.querySelector('button[onclick*="avatar-upload"]');
                    const removeBtnHtml = `
                        <button type="button" onclick="removeAvatar()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors duration-300 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            {{ __('messages.remove_avatar') }}
                        </button>
                    `;
                    uploadBtn.parentNode.insertAdjacentHTML('beforeend', removeBtnHtml);
                }
                
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message || '{{ __("messages.avatar_upload_failed") }}', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('{{ __("messages.avatar_upload_failed") }}', 'error');
        })
        .finally(() => {
            // Restore button state
            uploadBtn.innerHTML = originalText;
            uploadBtn.disabled = false;
            input.value = '';
        });
    }
}

function removeAvatar() {
    if (!confirm('{{ __("messages.delete_account_confirm") }}')) {
        return;
    }
    
    fetch('{{ route("avatar.remove") }}', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update avatar display to show initials
            const avatarContainer = document.querySelector('.w-20.h-20');
            avatarContainer.innerHTML = `
                <div class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">{{ $user->initials }}</span>
                </div>
            `;
            
            // Remove remove button
            const removeBtn = document.querySelector('button[onclick="removeAvatar()"]');
            if (removeBtn) {
                removeBtn.remove();
            }
            
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message || '{{ __("messages.avatar_remove_failed") }}', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('{{ __("messages.avatar_remove_failed") }}', 'error');
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transition = 'opacity 0.5s ease-out';
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        showNotification('URL copiada para a área de transferência!', 'success');
    }, function(err) {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        try {
            document.execCommand('copy');
            showNotification('URL copiada para a área de transferência!', 'success');
        } catch (err) {
            showNotification('Erro ao copiar URL', 'error');
        }
        document.body.removeChild(textArea);
    });
}

// Auto-hide success messages
setTimeout(function() {
    const successMessage = document.querySelector('.bg-green-500\\/20');
    if (successMessage) {
        successMessage.style.transition = 'opacity 0.5s ease-out';
        successMessage.style.opacity = '0';
        setTimeout(() => successMessage.remove(), 500);
    }
}, 5000);
</script>
@endsection
