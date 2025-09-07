<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskTemplateController;
use App\Http\Controllers\TimeTrackingController;
use App\Http\Controllers\ApiIntegrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

// Healthcheck route for Railway
Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'timestamp' => now()]);
});

// Welcome route for non-authenticated users
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home.index');
    }
    return view('welcome');
})->name('welcome');

// Rota para mudança de idioma
Route::get('/locale/{locale}', function ($locale) {
    // Verificar se o locale é válido
    if (in_array($locale, config('app.available_locales'))) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch');

Route::post('/theme/{theme}', function ($theme) {
    // Verificar se o tema é válido
    if (in_array($theme, ['light', 'dark'])) {
        session(['theme' => $theme]);
    }
    
    return response()->json(['success' => true]);
})->name('theme.switch');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // OAuth Routes
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    Route::get('/auth/github', [AuthController::class, 'redirectToGitHub'])->name('auth.github');
    Route::get('/auth/github/callback', [AuthController::class, 'handleGitHubCallback'])->name('auth.github.callback');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Avatar routes
    Route::post('/avatar/upload', [AvatarController::class, 'upload'])->name('avatar.upload');
    Route::delete('/avatar/remove', [AvatarController::class, 'remove'])->name('avatar.remove');
    Route::get('/avatar/info', [AvatarController::class, 'info'])->name('avatar.info');
});

// Public Profile Routes (no auth required)
Route::get('/profile/{identifier}', [PublicProfileController::class, 'show'])->name('profile.public');
Route::get('/profile/{identifier}/projects', [PublicProfileController::class, 'projects'])->name('profile.public.projects');
Route::get('/profile/{identifier}/github', [PublicProfileController::class, 'githubStats'])->name('profile.public.github');
Route::get('/developers', [PublicProfileController::class, 'search'])->name('developers.search');
Route::get('/api/trending', [PublicProfileController::class, 'trending'])->name('api.trending');

// Rota principal (home) - protegida por autenticação
Route::get('/dashboard', [HomeController::class, 'index'])->name('home.index')->middleware('auth');

// Rota de busca global - protegida por autenticação
Route::get('/search', [HomeController::class, 'search'])->name('search')->middleware('auth');

// Rotas das tarefas - protegidas por autenticação
Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/vue', [TaskController::class, 'vue'])->name('tasks.vue');
Route::get('/tasks/pro', [TaskController::class, 'professional'])->name('tasks.professional');
Route::get('/tasks/kanban', [TaskController::class, 'kanban'])->name('tasks.kanban');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
Route::patch('/tasks/{task}/toggle-favorite', [TaskController::class, 'toggleFavorite'])->name('tasks.toggleFavorite');

// API Routes for urgent tasks
Route::get('/api/urgent-task', [HomeController::class, 'getMostUrgentTask']);
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// Rotas de estatísticas
Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');

// Rotas de tema
Route::post('/theme/toggle', [ThemeController::class, 'toggle'])->name('theme.toggle');
Route::post('/theme/set', [ThemeController::class, 'setTheme'])->name('theme.set');
Route::get('/theme/current', [ThemeController::class, 'getCurrentTheme'])->name('theme.current');

// Rotas de projetos
Route::resource('projects', ProjectController::class);
Route::patch('/projects/{project}/toggle-favorite', [ProjectController::class, 'toggleFavorite'])->name('projects.toggle-favorite');

// Rotas de subtarefas
Route::resource('subtasks', SubtaskController::class);
Route::patch('/subtasks/{subtask}/toggle', [SubtaskController::class, 'toggle'])->name('subtasks.toggle');

// Rotas de templates
Route::resource('templates', TaskTemplateController::class);
Route::post('/templates/{template}/create-task', [TaskTemplateController::class, 'createTask'])->name('templates.createTask');

// API routes for FAB
Route::get('/api/projects', function() {
    return \App\Models\Project::where('is_active', true)->select('id', 'name')->get();
});

// API routes for Vue.js
Route::get('/api/tasks', [TaskController::class, 'apiIndex'])->name('api.tasks.index');
Route::get('/api/projects', [ProjectController::class, 'apiIndex'])->name('api.projects.index');

// Time Tracking API routes
Route::prefix('api/time-tracking')->group(function () {
    Route::post('/start', [TimeTrackingController::class, 'start'])->name('api.time-tracking.start');
    Route::post('/pause', [TimeTrackingController::class, 'pause'])->name('api.time-tracking.pause');
    Route::post('/resume', [TimeTrackingController::class, 'resume'])->name('api.time-tracking.resume');
    Route::post('/stop', [TimeTrackingController::class, 'stop'])->name('api.time-tracking.stop');
    Route::get('/status', [TimeTrackingController::class, 'status'])->name('api.time-tracking.status');
    Route::get('/history', [TimeTrackingController::class, 'history'])->name('api.time-tracking.history');
    Route::get('/stats', [TimeTrackingController::class, 'stats'])->name('api.time-tracking.stats');
    Route::get('/active-sessions', [TimeTrackingController::class, 'activeSessions'])->name('api.time-tracking.active-sessions');
});

// API Integration routes
Route::prefix('api/integrations')->group(function () {
    Route::get('/projects/{project}', [ApiIntegrationController::class, 'index'])->name('api.integrations.index');
    Route::post('/', [ApiIntegrationController::class, 'store'])->name('api.integrations.store');
    Route::put('/{integration}', [ApiIntegrationController::class, 'update'])->name('api.integrations.update');
    Route::delete('/{integration}', [ApiIntegrationController::class, 'destroy'])->name('api.integrations.destroy');
    Route::post('/{integration}/test', [ApiIntegrationController::class, 'testConnection'])->name('api.integrations.test');
    Route::post('/{integration}/sync-commits', [ApiIntegrationController::class, 'syncCommits'])->name('api.integrations.sync-commits');
    Route::get('/{integration}/commit-stats', [ApiIntegrationController::class, 'getCommitStats'])->name('api.integrations.commit-stats');
    Route::get('/{integration}/recent-commits', [ApiIntegrationController::class, 'getRecentCommits'])->name('api.integrations.recent-commits');
    Route::post('/{integration}/webhook', [ApiIntegrationController::class, 'createWebhook'])->name('api.integrations.create-webhook');
    Route::delete('/{integration}/webhook', [ApiIntegrationController::class, 'deleteWebhook'])->name('api.integrations.delete-webhook');
});
});