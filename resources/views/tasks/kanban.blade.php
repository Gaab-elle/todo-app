@extends('layouts.app')

@section('title', __('messages.kanban_board'))

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Navigation -->
    <nav class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <a href="{{ route('home.index') }}" 
                   class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>{{ __('messages.home') }}</span>
                </a>
                <a href="{{ route('tasks.index') }}" 
                   class="flex items-center space-x-2 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span>{{ __('messages.kanban_board') }}</span>
                </a>
                <a href="{{ route('stats.index') }}" 
                   class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>{{ __('messages.statistics') }}</span>
                </a>
            </div>
            
            <!-- Language Switcher -->
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-400">{{ __('messages.language') }}:</span>
                @foreach($availableLocales as $locale)
                    <a href="{{ route('locale.switch', $locale) }}" 
                       class="px-3 py-1 text-sm rounded {{ $currentLocale === $locale ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                        {{ strtoupper($locale) }}
                    </a>
                @endforeach
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-white mb-2">{{ __('messages.kanban_board') }}</h1>
        <p class="text-gray-400">{{ __('messages.drag_drop_tasks') }}</p>
    </div>

    <!-- Add Task Form -->
    <div class="bg-gray-800 rounded-lg p-6 mb-8 shadow-lg">
        <h2 class="text-xl font-semibold text-white mb-4">{{ __('messages.add_new_task') }}</h2>
        
        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('messages.title') }} *
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           required
                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="{{ __('messages.enter_task_title') }}">
                </div>
                
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('messages.priority') }} *
                    </label>
                    <select id="priority" 
                            name="priority" 
                            required
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">{{ __('messages.select_priority') }}</option>
                        <option value="low">{{ __('messages.low') }}</option>
                        <option value="medium">{{ __('messages.medium') }}</option>
                        <option value="high">{{ __('messages.high') }}</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('messages.status') }}
                    </label>
                    <select id="status" 
                            name="status"
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="pending">{{ __('messages.pending') }}</option>
                        <option value="in_progress">{{ __('messages.in_progress') }}</option>
                        <option value="review">{{ __('messages.review') }}</option>
                        <option value="completed">{{ __('messages.completed') }}</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('messages.description') }}
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="{{ __('messages.describe_task') }}"></textarea>
                </div>
                
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('messages.due_date') }}
                    </label>
                    <input type="date" 
                           id="due_date" 
                           name="due_date"
                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                    {{ __('messages.create_task') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Kanban Board -->
    <div class="drag-container">
        <ul class="drag-list">
            <!-- Pending Column -->
            <li class="drag-column drag-column-pending">
                <span class="drag-column-header">
                    <h2>{{ __('messages.pending') }}</h2>
                    <span class="task-count">{{ $tasksByStatus['pending']->count() }}</span>
                </span>
                <ul class="drag-inner-list" id="pending">
                    @foreach($tasksByStatus['pending'] as $task)
                        <li class="drag-item" data-task-id="{{ $task->id }}">
                            <div class="task-card">
                                <div class="task-header">
                                    <h3 class="task-title">{{ $task->title }}</h3>
                                    <span class="priority-badge priority-{{ $task->priority }}">
                                        {{ __("messages.{$task->priority}") }}
                                    </span>
                                </div>
                                @if($task->description)
                                    <p class="task-description">{{ $task->description }}</p>
                                @endif
                                <div class="task-footer">
                                    @if($task->due_date)
                                        <span class="due-date {{ $task->due_date < now() ? 'overdue' : '' }}">
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                        </span>
                                    @endif
                                    <div class="task-actions">
                                        <button type="button" data-task-id="{{ $task->id }}" class="delete-btn" onclick="deleteTask(this.getAttribute('data-task-id'))">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </li>

            <!-- In Progress Column -->
            <li class="drag-column drag-column-in-progress">
                <span class="drag-column-header">
                    <h2>{{ __('messages.in_progress') }}</h2>
                    <span class="task-count">{{ $tasksByStatus['in_progress']->count() }}</span>
                </span>
                <ul class="drag-inner-list" id="in_progress">
                    @foreach($tasksByStatus['in_progress'] as $task)
                        <li class="drag-item" data-task-id="{{ $task->id }}">
                            <div class="task-card">
                                <div class="task-header">
                                    <h3 class="task-title">{{ $task->title }}</h3>
                                    <span class="priority-badge priority-{{ $task->priority }}">
                                        {{ __("messages.{$task->priority}") }}
                                    </span>
                                </div>
                                @if($task->description)
                                    <p class="task-description">{{ $task->description }}</p>
                                @endif
                                <div class="task-footer">
                                    @if($task->due_date)
                                        <span class="due-date {{ $task->due_date < now() ? 'overdue' : '' }}">
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                        </span>
                                    @endif
                                    <div class="task-actions">
                                        <button type="button" data-task-id="{{ $task->id }}" class="delete-btn" onclick="deleteTask(this.getAttribute('data-task-id'))">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </li>

            <!-- Review Column -->
            <li class="drag-column drag-column-review">
                <span class="drag-column-header">
                    <h2>{{ __('messages.review') }}</h2>
                    <span class="task-count">{{ $tasksByStatus['review']->count() }}</span>
                </span>
                <ul class="drag-inner-list" id="review">
                    @foreach($tasksByStatus['review'] as $task)
                        <li class="drag-item" data-task-id="{{ $task->id }}">
                            <div class="task-card">
                                <div class="task-header">
                                    <h3 class="task-title">{{ $task->title }}</h3>
                                    <span class="priority-badge priority-{{ $task->priority }}">
                                        {{ __("messages.{$task->priority}") }}
                                    </span>
                                </div>
                                @if($task->description)
                                    <p class="task-description">{{ $task->description }}</p>
                                @endif
                                <div class="task-footer">
                                    @if($task->due_date)
                                        <span class="due-date {{ $task->due_date < now() ? 'overdue' : '' }}">
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                        </span>
                                    @endif
                                    <div class="task-actions">
                                        <button type="button" data-task-id="{{ $task->id }}" class="delete-btn" onclick="deleteTask(this.getAttribute('data-task-id'))">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </li>

            <!-- Completed Column -->
            <li class="drag-column drag-column-completed">
                <span class="drag-column-header">
                    <h2>{{ __('messages.completed') }}</h2>
                    <span class="task-count">{{ $tasksByStatus['completed']->count() }}</span>
                </span>
                <ul class="drag-inner-list" id="completed">
                    @foreach($tasksByStatus['completed'] as $task)
                        <li class="drag-item" data-task-id="{{ $task->id }}">
                            <div class="task-card">
                                <div class="task-header">
                                    <h3 class="task-title">{{ $task->title }}</h3>
                                    <span class="priority-badge priority-{{ $task->priority }}">
                                        {{ __("messages.{$task->priority}") }}
                                    </span>
                                </div>
                                @if($task->description)
                                    <p class="task-description">{{ $task->description }}</p>
                                @endif
                                <div class="task-footer">
                                    @if($task->due_date)
                                        <span class="due-date {{ $task->due_date < now() ? 'overdue' : '' }}">
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                        </span>
                                    @endif
                                    <div class="task-actions">
                                        <button type="button" data-task-id="{{ $task->id }}" class="delete-btn" onclick="deleteTask(this.getAttribute('data-task-id'))">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>
</div>

<!-- CSRF Token for AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@push('styles')
<style>
/* Kanban Drag and Drop Styles */
.drag-container {
    max-width: 100%;
    margin: 20px 0;
}

.drag-list {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    overflow-x: auto;
    padding-bottom: 20px;
}

.drag-column {
    flex: 1;
    min-width: 280px;
    background: rgba(31, 41, 55, 0.8);
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(75, 85, 99, 0.3);
    transition: all 0.3s ease;
}

.drag-column.drag-active {
    border-color: #3b82f6;
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
}

.drag-inner-list.drag-over {
    background: rgba(59, 130, 246, 0.05);
    border: 2px dashed #3b82f6;
    border-radius: 8px;
}

.drag-column-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.05em;
}

.drag-column-header h2 {
    margin: 0;
    color: white;
}

.task-count {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.drag-column-pending .drag-column-header {
    background: #FB7D44;
}

.drag-column-in-progress .drag-column-header {
    background: #2A92BF;
}

.drag-column-review .drag-column-header {
    background: #F4CE46;
    color: #1f2937;
}

.drag-column-completed .drag-column-header {
    background: #00B961;
}

.drag-inner-list {
    min-height: 100px;
    padding: 16px;
    padding-top: 0;
}

.drag-item {
    margin-bottom: 12px;
    cursor: grab;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    list-style: none;
    user-select: none;
}

.drag-item:active {
    cursor: grabbing;
}

.drag-item.is-moving {
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    z-index: 1000;
}

.drag-item.is-moved {
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.task-card {
    background: rgba(55, 65, 81, 0.9);
    border-radius: 12px;
    padding: 16px;
    border: 1px solid rgba(75, 85, 99, 0.4);
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    min-height: 120px;
    display: flex;
    flex-direction: column;
}

.task-card:hover {
    background: rgba(55, 65, 81, 1);
    border-color: rgba(75, 85, 99, 0.6);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

.task-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
    gap: 8px;
}

.task-title {
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    margin: 0;
    flex: 1;
    line-height: 1.3;
}

.priority-badge {
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.priority-high {
    background: #ef4444;
    color: white;
}

.priority-medium {
    background: #f59e0b;
    color: white;
}

.priority-low {
    background: #10b981;
    color: white;
}

.task-description {
    color: #d1d5db;
    font-size: 0.8rem;
    margin: 0 0 12px 0;
    line-height: 1.4;
    flex: 1;
}

.task-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 8px;
    border-top: 1px solid rgba(75, 85, 99, 0.3);
}

.due-date {
    color: #9ca3af;
    font-size: 0.75rem;
}

.due-date.overdue {
    color: #ef4444;
    font-weight: 600;
}

.task-actions {
    display: flex;
    gap: 8px;
}

.delete-btn {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #ef4444;
    padding: 6px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-btn:hover {
    background: rgba(239, 68, 68, 0.2);
    border-color: rgba(239, 68, 68, 0.5);
    transform: scale(1.1);
}

/* Dragula CSS */
.gu-mirror {
    position: fixed !important;
    margin: 0 !important;
    z-index: 9999 !important;
    opacity: 0.9;
    list-style-type: none;
    transform: rotate(5deg);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    pointer-events: none;
}

.gu-mirror .task-card {
    background: rgba(55, 65, 81, 1) !important;
    border: 2px solid #3b82f6 !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
}

.gu-hide {
    display: none !important;
}

.gu-unselectable {
    -webkit-user-select: none !important;
    -moz-user-select: none !important;
    -ms-user-select: none !important;
    user-select: none !important;
}

.gu-transit {
    opacity: 0.3 !important;
    background: rgba(59, 130, 246, 0.1) !important;
    border: 2px dashed #3b82f6 !important;
}

.gu-transit .task-card {
    background: rgba(59, 130, 246, 0.1) !important;
    border: 2px dashed #3b82f6 !important;
}

/* Ensure drag items are draggable */
.drag-item {
    -webkit-user-drag: element;
    -khtml-user-drag: element;
    -moz-user-drag: element;
    -o-user-drag: element;
}

/* Responsive */
@media (max-width: 768px) {
    .drag-list {
        flex-direction: column;
    }
    
    .drag-column {
        min-width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/dragula@3.7.3/dist/dragula.min.js"></script>
<script>
// Simple drag and drop initialization
window.addEventListener('load', function() {
    console.log('Page loaded, initializing dragula...');
    
    // Check if dragula is available
    if (typeof dragula === 'undefined') {
        console.error('Dragula library not found!');
        return;
    }
    
    // Get containers
    const pending = document.getElementById('pending');
    const inProgress = document.getElementById('in_progress');
    const review = document.getElementById('review');
    const completed = document.getElementById('completed');
    
    if (!pending || !inProgress || !review || !completed) {
        console.error('One or more containers not found!');
        return;
    }
    
    console.log('All containers found, initializing dragula...');
    
    // Initialize dragula
    const drake = dragula([pending, inProgress, review, completed]);
    
    // Add event listeners
    drake.on('drag', function(el) {
        console.log('Dragging:', el);
        el.classList.add('is-moving');
    });
    
    drake.on('dragend', function(el) {
        console.log('Drag ended:', el);
        el.classList.remove('is-moving');
    });
    
    drake.on('drop', function(el, target, source, sibling) {
        console.log('Dropped:', el, 'into:', target);
        const taskId = el.getAttribute('data-task-id');
        const newStatus = target.id;
        
        console.log('Updating task', taskId, 'to status', newStatus);
        
        // Update via AJAX
        updateTaskStatus(taskId, newStatus);
    });
    
    console.log('Dragula initialized successfully!');
});

function updateTaskStatus(taskId, status) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/tasks/${taskId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            status: status
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Task status updated:', data);
        // Update task count in header
        updateTaskCounts();
    })
    .catch(error => {
        console.error('Error updating task status:', error);
        // Optionally show error message to user
    });
}

function updateTaskCounts() {
    // Update task counts in column headers
    const columns = ['pending', 'in_progress', 'review', 'completed'];
    columns.forEach(status => {
        const count = document.getElementById(status).children.length;
        const countElement = document.querySelector(`#${status}`).closest('.drag-column').querySelector('.task-count');
        if (countElement) {
            countElement.textContent = count;
        }
    });
}

function deleteTask(taskId) {
    if (confirm('{{ __("messages.confirm_delete") }}')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(`/tasks/${taskId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                // Remove task from DOM
                const taskElement = document.querySelector(`[data-task-id="${taskId}"]`);
                if (taskElement) {
                    taskElement.remove();
                    updateTaskCounts();
                }
            }
        })
        .catch(error => {
            console.error('Error deleting task:', error);
        });
    }
}
</script>
@endpush
