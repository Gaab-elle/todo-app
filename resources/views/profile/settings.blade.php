@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-transparent">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('messages.settings') }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('messages.settings_description') }}</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-green-800 dark:text-green-200 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-red-800 dark:text-red-200 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Settings Sidebar -->
            <div class="lg:col-span-1">
                <nav class="space-y-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">{{ __('messages.account') }}</h3>
                        <div class="space-y-1">
                            <a href="javascript:void(0)" class="block px-3 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 rounded-md">
                                {{ __('messages.public_profile') }}
                            </a>
                            <a href="javascript:void(0)" class="block px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md">
                                {{ __('messages.account_settings') }}
                            </a>
                            <a href="javascript:void(0)" class="block px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md">
                                {{ __('messages.appearance') }}
                            </a>
                            <a href="javascript:void(0)" class="block px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md">
                                {{ __('messages.notifications') }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">{{ __('messages.access') }}</h3>
                        <div class="space-y-1">
                            <a href="javascript:void(0)" class="block px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md">
                                {{ __('messages.password_and_authentication') }}
                            </a>
                            <a href="javascript:void(0)" class="block px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md">
                                {{ __('messages.sessions') }}
                            </a>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Public Profile Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <!-- Header -->
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.your_personal_account') }}</p>
                            </div>
                            <a href="{{ route('profile.public', auth()->user()->username ?? auth()->user()->id) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                {{ __('messages.go_to_personal_profile') }}
                            </a>
                        </div>
                    </div>

                    <!-- Profile Picture Section -->
                    <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-start space-x-6">
                            <div class="flex-shrink-0">
                                <div class="relative group">
                                    <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-300 dark:border-gray-600">
                                        @if($user->avatar)
                                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                                <span class="text-white text-2xl font-bold">{{ $user->initials }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer" onclick="document.getElementById('avatar-upload').click()">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <button type="button" onclick="document.getElementById('avatar-upload').click()" class="mt-3 text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                    {{ __('messages.edit') }}
                                </button>
                                @if($user->avatar)
                                    <button type="button" onclick="removeAvatar()" class="mt-2 block text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                        {{ __('messages.remove') }}
                                    </button>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('messages.public_profile') }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                                    {{ __('messages.public_profile_description') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Section -->
                    <form method="POST" action="{{ route('profile.update') }}" class="px-6 py-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                                    {{ __('messages.name_label') }}
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="{{ __('messages.name_label') }}">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('messages.name_help') }}
                                </p>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                                    {{ __('messages.public_email') }}
                                </label>
                                <select id="email" name="email" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="{{ $user->email }}">{{ $user->email }}</option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('messages.public_email_help') }}
                                </p>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bio Field -->
                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                                    {{ __('messages.bio_label') }}
                                </label>
                                <textarea id="bio" 
                                          name="bio" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                          placeholder="{{ __('messages.bio_placeholder') }}">{{ old('bio', $user->bio) }}</textarea>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('messages.bio_help') }}
                                </p>
                                @error('bio')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Username Field -->
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                                    {{ __('messages.username_label') }}
                                </label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-400 text-sm">
                                        {{ url('/profile/') }}/
                                    </span>
                                    <input type="text" 
                                           id="username" 
                                           name="username" 
                                           value="{{ old('username', $user->username) }}"
                                           class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-r-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="{{ __('messages.username_label') }}">
                                </div>
                                @error('username')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Location Field -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                                    {{ __('messages.location_label') }}
                                </label>
                                <input type="text" 
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location', $user->location) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="{{ __('messages.location_placeholder') }}">
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Website Field -->
                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                                    {{ __('messages.website_label') }}
                                </label>
                                <input type="url" 
                                       id="website" 
                                       name="website" 
                                       value="{{ old('website', $user->website) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="{{ __('messages.website_placeholder') }}">
                                @error('website')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Social Accounts -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4">{{ __('messages.social_accounts') }}</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label for="linkedin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            {{ __('messages.linkedin_label') }}
                                        </label>
                                        <input type="text" 
                                               id="linkedin" 
                                               name="linkedin" 
                                               value="{{ old('linkedin', $user->linkedin) }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="{{ __('messages.linkedin_placeholder') }}">
                                        @error('linkedin')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="twitter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            {{ __('messages.twitter_label') }}
                                        </label>
                                        <input type="text" 
                                               id="twitter" 
                                               name="twitter" 
                                               value="{{ old('twitter', $user->twitter) }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="{{ __('messages.twitter_placeholder') }}">
                                        @error('twitter')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="github_username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            {{ __('messages.github_label') }}
                                        </label>
                                        <input type="text" 
                                               id="github_username" 
                                               name="github_username" 
                                               value="{{ old('github_username', $user->github_username) }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="{{ __('messages.github_placeholder') }}">
                                        @error('github_username')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    {{ __('messages.update_profile') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden File Input -->
<input type="file" id="avatar-upload" accept="image/*" class="hidden" onchange="uploadAvatar(this)">

<script>
// Avatar Upload Functions
function uploadAvatar(input) {
    if (input.files && input.files[0]) {
        const formData = new FormData();
        formData.append('avatar', input.files[0]);
        
        fetch('/avatar/upload', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao fazer upload: ' + (data.message || 'Erro desconhecido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro ao fazer upload do avatar');
        });
    }
}

function removeAvatar() {
    if (confirm('Tem certeza que deseja remover seu avatar?')) {
        fetch('/avatar/remove', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao remover avatar: ' + (data.message || 'Erro desconhecido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro ao remover avatar');
        });
    }
}
</script>
@endsection
