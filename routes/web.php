<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

// Rota para mudança de idioma
Route::get('/locale/{locale}', function ($locale) {
    // Verificar se o locale é válido
    if (in_array($locale, config('app.available_locales'))) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch');

// Rota principal (home)
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// Rotas das tarefas
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/pro', [TaskController::class, 'professional'])->name('tasks.professional');
Route::get('/tasks/kanban', [TaskController::class, 'kanban'])->name('tasks.kanban');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// Rotas de estatísticas
Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');

// Rotas de tema
Route::post('/theme/toggle', [ThemeController::class, 'toggle'])->name('theme.toggle');
Route::post('/theme/set', [ThemeController::class, 'setTheme'])->name('theme.set');
Route::get('/theme/current', [ThemeController::class, 'getCurrentTheme'])->name('theme.current');