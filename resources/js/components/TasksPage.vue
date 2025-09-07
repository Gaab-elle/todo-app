<template>
  <div class="app">
    <main class="project">
      <div class="project-info">
        <h1>Gerenciar Tarefas</h1>
        <div class="project-participants">
          <span></span>
          <span></span>
          <span></span>
          <button class="project-participants__add" @click="createTask">Adicionar Nova Tarefa</button>
        </div>
      </div>
      
      <div class="project-tasks">
        <div 
          v-for="(column, index) in columns"
          :key="column.status"
          class="project-column"
          :class="{ 'column-hover': draggedTaskId && hoveredColumn === column.status }"
          @dragover="handleColumnDragOver($event, column.status)"
          @dragenter="handleColumnDragEnter($event, column.status)"
          @dragleave="handleColumnDragLeave"
          @drop="handleColumnDrop($event, column.status)"
        >
          <div class="project-column-heading">
            <h2 class="project-column-heading__title">{{ t(column.title) }}</h2>
            <button class="project-column-heading__options">
              <i class="fas fa-ellipsis-h"></i>
            </button>
          </div>
          
          <!-- Tasks in this column -->
          <div
            v-for="(task, taskIndex) in column.tasks"
            :key="`${task.id}-${taskIndex}`"
            class="task"
            :class="{ 'dragging': draggedTaskId === task.id }"
            draggable="true"
            :data-task-id="task.id"
            @dragstart="handleDragStart($event, task)"
            @dragend="handleDragEnd"
          >
            <div class="task__tags">
              <span 
                class="task__tag"
                :class="getTaskTagClass(task.priority)"
              >
                {{ t(`${task.priority}`) }}
              </span>
              <div class="task__actions">
                <button class="task__action-btn task__favorite-btn" @click="toggleFavorite(task)" :title="task.is_favorite ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos'">
                  <svg class="w-4 h-4" :fill="task.is_favorite ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                  </svg>
                </button>
                <button class="task__action-btn task__edit-btn" @click="editTask(task)" title="Editar Tarefa">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                  </svg>
                </button>
                <button class="task__action-btn task__delete-btn" @click="deleteTask(task)" title="Excluir Tarefa">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </button>
              </div>
            </div>
            
            <p>{{ task.title }}</p>
            
            <div class="task__stats">
              <span v-if="task.due_date">
                <time :datetime="task.due_date">
                  <i class="fas fa-flag"></i>{{ formatDate(task.due_date) }}
                </time>
              </span>
              <span><i class="fas fa-comment"></i>{{ task.comments_count || 0 }}</span>
              <span><i class="fas fa-paperclip"></i>{{ task.attachments_count || 0 }}</span>
              <span class="task__owner"></span>
            </div>
          </div>
          
          <!-- Empty state -->
          <div v-if="column.tasks.length === 0" class="empty-column">
            <p>{{ t(`no_${column.status}_tasks`) }}</p>
          </div>
        </div>
      </div>
    </main>
    
  </div>

  <!-- Task Creation/Edit Modal -->
  <div v-if="showModal" class="modal-overlay" @click="closeModal">
    <div class="modal-content" @click.stop>
      <h3 class="modal-title">{{ isEditing ? t('edit_task') : t('add_new_task') }}</h3>
      
      <form @submit.prevent="saveTask">
        <div class="form-group">
          <label class="form-label">{{ t('title') }}</label>
          <input
            v-model="taskForm.title"
            type="text"
            required
            class="form-input"
            :placeholder="t('enter_task_title')"
          />
        </div>
        
        <div class="form-group">
          <label class="form-label">{{ t('description') }}</label>
          <textarea
            v-model="taskForm.description"
            rows="3"
            class="form-textarea"
            :placeholder="t('enter_task_description')"
          ></textarea>
        </div>
        
        <div class="form-group">
          <label class="form-label">{{ t('priority') }}</label>
          <select v-model="taskForm.priority" class="form-select">
            <option value="low">{{ t('low') }}</option>
            <option value="medium">{{ t('medium') }}</option>
            <option value="high">{{ t('high') }}</option>
          </select>
        </div>
        
        <div class="form-actions">
          <button type="button" @click="closeModal" class="btn btn-secondary">
            {{ t('cancel') }}
          </button>
          <button type="submit" class="btn btn-primary">
            {{ isEditing ? t('update_task') : t('save_task') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, reactive, watch, nextTick } from 'vue'
import { useTaskStore } from '../stores/taskStore'

const taskStore = useTaskStore()

// Modal state
const showModal = ref(false)
const isEditing = ref(false)
const editingTaskId = ref(null)
const taskForm = ref({
  title: '',
  description: '',
  priority: 'medium'
})

// Global translation function
const t = (key) => {
  return window.translations && window.translations[key] ? window.translations[key] : key
}

// Helper functions
const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('pt-BR')
}

// Drag and Drop state
const draggedTaskId = ref(null)
const draggedTask = ref(null)
const originalColumn = ref(null)
const hoveredColumn = ref(null)

// Columns structure
const columns = reactive([
  { 
    title: 'pending', 
    status: 'pending', 
    tasks: []
  },
  { 
    title: 'in_progress', 
    status: 'in_progress', 
    tasks: []
  },
  { 
    title: 'review', 
    status: 'review', 
    tasks: []
  },
  { 
    title: 'completed', 
    status: 'completed', 
    tasks: []
  }
])

// Computed properties
const loading = computed(() => taskStore.loading)
const error = computed(() => taskStore.error)
const tasksByStatus = computed(() => taskStore.tasksByStatus)
const taskStats = computed(() => taskStore.taskStats)

// Mock recent activities
const recentActivities = ref([
  {
    id: 1,
    type: 'attachment',
    icon: 'fas fa-paperclip',
    user: 'Andrea',
    action: 'uploaded 3 documents',
    date: new Date().toISOString()
  },
  {
    id: 2,
    type: 'comment',
    icon: 'fas fa-comment',
    user: 'Karen',
    action: 'left a comment',
    date: new Date().toISOString()
  },
  {
    id: 3,
    type: 'edit',
    icon: 'fas fa-pencil-alt',
    user: 'Karen',
    action: 'updated task',
    date: new Date().toISOString()
  }
])

// Update columns when tasks change
const updateColumns = () => {
  columns.forEach(column => {
    column.tasks = tasksByStatus.value[column.status] || []
  })
}

const refreshTasks = () => {
  taskStore.fetchTasks()
}

const createTask = () => {
  isEditing.value = false
  editingTaskId.value = null
  taskForm.value = {
    title: '',
    description: '',
    priority: 'medium'
  }
  showModal.value = true
}

const editTask = (task) => {
  isEditing.value = true
  editingTaskId.value = task.id
  taskForm.value = {
    title: task.title,
    description: task.description || '',
    priority: task.priority
  }
  showModal.value = true
}

const deleteTask = async (task) => {
  if (confirm(t('confirm_delete'))) {
    try {
      await taskStore.deleteTask(task.id)
      refreshTasks()
    } catch (error) {
      console.error('Error deleting task:', error)
    }
  }
}

const toggleFavorite = async (task) => {
  try {
    console.log('Before toggle - Task:', task.title, 'is_favorite:', task.is_favorite)
    
    // Toggle favorite status
    const newFavoriteStatus = !task.is_favorite
    console.log('New favorite status:', newFavoriteStatus)
    
    // Update UI immediately (optimistic update)
    task.is_favorite = newFavoriteStatus
    console.log('UI updated - Task:', task.title, 'is_favorite:', task.is_favorite)
    
    // Use the specific toggle-favorite endpoint
    const response = await window.axios.patch(`/tasks/${task.id}/toggle-favorite`)
    
    console.log('Backend response:', response.data)
    console.log('Favorite toggled successfully:', task.title, 'is_favorite:', response.data.is_favorite)
    
    // Update the task with the response from backend
    task.is_favorite = response.data.is_favorite
  } catch (error) {
    console.error('Error toggling favorite:', error)
    // Revert on error
    task.is_favorite = !task.is_favorite
    console.log('Reverted - Task:', task.title, 'is_favorite:', task.is_favorite)
  }
}

const saveTask = async () => {
  if (!taskForm.value.title.trim()) return
  
  try {
    if (isEditing.value) {
      await taskStore.updateTask(editingTaskId.value, {
        title: taskForm.value.title,
        description: taskForm.value.description,
        priority: taskForm.value.priority
      })
    } else {
      await taskStore.createTask({
        title: taskForm.value.title,
        description: taskForm.value.description,
        status: 'pending',
        priority: taskForm.value.priority
      })
    }
    closeModal()
    refreshTasks()
  } catch (error) {
    console.error('Error saving task:', error)
  }
}

const closeModal = () => {
  showModal.value = false
  isEditing.value = false
  editingTaskId.value = null
  taskForm.value = {
    title: '',
    description: '',
    priority: 'medium'
  }
}

// Get task tag class based on priority
const getTaskTagClass = (priority) => {
  const classes = {
    'high': 'task__tag--high',
    'medium': 'task__tag--medium', 
    'low': 'task__tag--low'
  }
  return classes[priority] || 'task__tag--medium'
}

// Get priority count
const getPriorityCount = (priority) => {
  return columns.reduce((count, column) => {
    return count + column.tasks.filter(task => task.priority === priority).length
  }, 0)
}

// Drag and Drop handlers
const handleDragStart = (e, task) => {
  console.log('Drag start:', task.id)
  
  draggedTaskId.value = task.id
  draggedTask.value = task
  originalColumn.value = getTaskColumn(task.id)
  
  e.dataTransfer.effectAllowed = 'move'
  e.dataTransfer.setData('text/plain', task.id.toString())
}

const handleDragEnd = (e) => {
  console.log('Drag end')
  
  // Clean up
  draggedTaskId.value = null
  draggedTask.value = null
  originalColumn.value = null
  hoveredColumn.value = null
}

// Column drag handlers
const handleColumnDragOver = (e, columnStatus) => {
  e.preventDefault()
  e.dataTransfer.dropEffect = 'move'
  hoveredColumn.value = columnStatus
}

const handleColumnDragEnter = (e, columnStatus) => {
  e.preventDefault()
  hoveredColumn.value = columnStatus
}

const handleColumnDragLeave = (e) => {
  // Only clear hover if we're leaving the column entirely
  if (!e.currentTarget.contains(e.relatedTarget)) {
    hoveredColumn.value = null
  }
}

const handleColumnDrop = async (e, targetStatus) => {
  e.preventDefault()
  
  if (!draggedTask.value || targetStatus === originalColumn.value) {
    return
  }
  
  console.log('Dropping task', draggedTask.value.id, 'into column', targetStatus)
  
  // Move task in UI
  const sourceColumn = columns.find(c => c.status === originalColumn.value)
  const targetColumn = columns.find(c => c.status === targetStatus)
  
  if (sourceColumn && targetColumn) {
    const taskIndex = sourceColumn.tasks.findIndex(t => t.id === draggedTask.value.id)
    if (taskIndex !== -1) {
      const movedTask = sourceColumn.tasks.splice(taskIndex, 1)[0]
      targetColumn.tasks.push(movedTask)
      
      // Update backend
      try {
        await updateTaskStatus(draggedTask.value.id, targetStatus)
        console.log('Task moved successfully')
      } catch (error) {
        console.error('Error moving task:', error)
        // Revert UI change on error
        sourceColumn.tasks.splice(taskIndex, 0, movedTask)
        targetColumn.tasks.pop()
        refreshTasks()
      }
    }
  }
  
  // Clean up
  hoveredColumn.value = null
}

const getTaskColumn = (taskId) => {
  return columns.find(c => c.tasks.some(t => t.id === taskId))?.status
}

const getColumnStatus = (columnElement) => {
  const columnIndex = Array.from(columnElement.parentNode.children).indexOf(columnElement)
  return columns[columnIndex]?.status
}

const updateTaskStatus = async (taskId, newStatus) => {
  console.log('Updating task:', taskId, 'to status:', newStatus)
  
  try {
    // Use Axios which is already configured with CSRF token
    const response = await window.axios.patch(`/tasks/${taskId}/status`, {
      status: newStatus
    })
    
    console.log('Status atualizado:', response.data)
    
    taskStore.updateTaskStatus(taskId, newStatus)
    return response.data
  } catch (error) {
    console.error('Error updating task status:', error)
    
    // Fallback to fetch if Axios fails
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
    console.log('Trying with fetch, CSRF Token:', csrfToken)
    
    const response = await fetch(`/tasks/${taskId}/status`, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ status: newStatus })
    })
    
    console.log('Response status:', response.status)
    
    if (!response.ok) {
      const errorText = await response.text()
      console.error('Error response:', errorText)
      throw new Error(`Failed to update task status: ${response.status} ${errorText}`)
    }
    
    const data = await response.json()
    console.log('Status atualizado via fetch:', data)
    
    taskStore.updateTaskStatus(taskId, newStatus)
    return data
  }
}

onMounted(() => {
  taskStore.fetchTasks()
})

// Watch for changes in tasksByStatus
watch(tasksByStatus, () => {
  updateColumns()
}, { deep: true })
</script>

<style scoped>
/* CSS Variables - Clean Modern Design */
:root {
  --primary: #6366f1;
  --primary-light: #e0e7ff;
  --primary-dark: #4f46e5;
  
  --success: #10b981;
  --warning: #f59e0b;
  --danger: #ef4444;
  
  --gray-50: #f9fafb;
  --gray-100: #f3f4f6;
  --gray-200: #e5e7eb;
  --gray-300: #d1d5db;
  --gray-400: #9ca3af;
  --gray-500: #6b7280;
  --gray-600: #4b5563;
  --gray-700: #374151;
  --gray-800: #1f2937;
  --gray-900: #111827;
  
  --white: #ffffff;
  --black: #000000;
  
  --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
  --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.app {
  background: var(--gray-50);
  width: 100%;
  min-height: 100vh;
  display: flex;
  gap: 0;
  padding: 0;
  margin: 0;
}

h1 {
  font-size: 32px;
  font-weight: 800;
  color: var(--gray-900);
  margin-bottom: 0.5rem;
  letter-spacing: -0.025em;
}

.project {
  padding: 2rem;
  width: 100%;
  display: block;
  background: transparent;
}

.project-info {
  padding: 1.5rem 0 2rem 0;
  display: flex;
  width: 100%;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid var(--gray-200);
  margin-bottom: 2rem;
}

.project-participants {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.project-participants span {
  width: 36px;
  height: 36px;
  display: inline-block;
  background: var(--primary);
  border-radius: 50%;
  border: 3px solid var(--white);
  box-shadow: var(--shadow-md);
}

.project-participants__add {
  background: var(--white);
  border: 2px solid var(--gray-300);
  border-radius: 12px;
  padding: 10px 20px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  color: var(--gray-700);
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  box-shadow: var(--shadow-sm);
}

.project-participants__add:hover {
  border-color: var(--primary);
  color: var(--primary);
  background: var(--primary-light);
  transform: translateY(-1px);
  box-shadow: var(--shadow-md);
}

.project-tasks {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  width: 100%;
  gap: 1.5rem;
  min-height: 600px;
}

.project-column {
  background: rgba(0, 0, 0, 0.4);
  border-radius: 16px;
  padding: 1.5rem;
  border: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
  display: flex;
  flex-direction: column;
  transition: all 0.2s ease;
  backdrop-filter: blur(10px);
}

.project-column:hover {
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
  border-color: rgba(255, 255, 255, 0.2);
  background: rgba(0, 0, 0, 0.5);
}

.project-column.column-hover {
  border-color: var(--primary);
  background: rgba(99, 102, 241, 0.3);
  transform: scale(1.02);
  box-shadow: 0 16px 48px rgba(99, 102, 241, 0.4);
}

.project-column-heading {
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-bottom: 1rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.project-column-heading__title {
  font-size: 16px;
  font-weight: 700;
  color: rgba(255, 255, 255, 0.9);
  display: flex;
  align-items: center;
  gap: 0.75rem;
  letter-spacing: -0.025em;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.project-column-heading__title::before {
  content: '';
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: var(--gray-400);
}

.project-column:nth-child(1) .project-column-heading__title::before {
  background: var(--gray-500);
}

.project-column:nth-child(2) .project-column-heading__title::before {
  background: var(--primary);
}

.project-column:nth-child(3) .project-column-heading__title::before {
  background: var(--warning);
}

.project-column:nth-child(4) .project-column-heading__title::before {
  background: var(--success);
}

.project-column-heading__options {
  background: transparent;
  color: rgba(255, 255, 255, 0.6);
  font-size: 16px;
  border: 0;
  cursor: pointer;
  padding: 8px;
  border-radius: 8px;
  transition: all 0.2s ease;
}

.project-column-heading__options:hover {
  background: rgba(255, 255, 255, 0.1);
  color: rgba(255, 255, 255, 0.9);
}

.task {
  cursor: move;
  background-color: rgba(0, 0, 0, 0.3);
  padding: 1.25rem;
  border-radius: 12px;
  width: 100%;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
  margin-bottom: 1rem;
  border: 1px solid rgba(255, 255, 255, 0.1);
  transition: all 0.2s ease;
  position: relative;
  backdrop-filter: blur(10px);
}

.task:hover {
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
  border-color: rgba(255, 255, 255, 0.2);
  transform: translateY(-2px);
  background-color: rgba(0, 0, 0, 0.4);
}

.task.dragging {
  opacity: 0.8;
  border: 2px dashed rgba(255, 255, 255, 0.4);
  transform: rotate(1deg) scale(1.02);
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
}

.task p {
  font-size: 15px;
  font-weight: 600;
  margin: 1rem 0;
  color: rgba(255, 255, 255, 0.9);
  line-height: 1.5;
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.task__tag {
  border-radius: 8px;
  padding: 6px 12px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
  backdrop-filter: blur(5px);
  transition: all 0.2s ease;
}

.task__tag--high {
  color: #ffffff;
  background-color: rgba(239, 68, 68, 0.8);
  border: 1px solid rgba(239, 68, 68, 0.6);
  box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
}

.task__tag--high:hover {
  background-color: rgba(239, 68, 68, 0.9);
  box-shadow: 0 4px 8px rgba(239, 68, 68, 0.4);
  transform: translateY(-1px);
}

.task__tag--medium {
  color: #ffffff;
  background-color: rgba(245, 158, 11, 0.8);
  border: 1px solid rgba(245, 158, 11, 0.6);
  box-shadow: 0 2px 4px rgba(245, 158, 11, 0.3);
}

.task__tag--medium:hover {
  background-color: rgba(245, 158, 11, 0.9);
  box-shadow: 0 4px 8px rgba(245, 158, 11, 0.4);
  transform: translateY(-1px);
}

.task__tag--low {
  color: #ffffff;
  background-color: rgba(16, 185, 129, 0.8);
  border: 1px solid rgba(16, 185, 129, 0.6);
  box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
}

.task__tag--low:hover {
  background-color: rgba(16, 185, 129, 0.9);
  box-shadow: 0 4px 8px rgba(16, 185, 129, 0.4);
  transform: translateY(-1px);
}

.task__tags { 
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 0.5rem;
}

.task__actions {
  display: flex;
  gap: 0.75rem;
  align-items: center;
}

.task__action-btn {
  background: transparent;
  border: none;
  cursor: pointer;
  padding: 8px;
  border-radius: 6px;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 36px;
  height: 36px;
}

/* SVG Icons - Same as projects page */
.task__actions svg {
  width: 16px;
  height: 16px;
  color: rgba(255, 255, 255, 0.7);
  transition: color 0.2s ease;
}

.task__action-btn:hover {
  background: rgba(255, 255, 255, 0.1);
  transform: translateY(-1px);
}


.task__favorite-btn:hover svg {
  color: #fbbf24;
}

/* Estrela favorita - amarela */
.task__favorite-btn svg[fill="currentColor"] {
  color: #fbbf24;
}

.task__edit-btn:hover svg {
  color: #60a5fa;
}

.task__delete-btn:hover svg {
  color: #f87171;
}

.task__options {
  background: transparent; 
  border: 0;
  color: rgba(255, 255, 255, 0.6);
  font-size: 16px;
  cursor: pointer;
  padding: 6px;
  border-radius: 6px;
  transition: all 0.2s ease;
}

.task__options:hover {
  background: rgba(255, 255, 255, 0.1);
  color: rgba(255, 255, 255, 0.9);
}

.task__stats {
  position: relative;
  width: 100%;
  color: rgba(255, 255, 255, 0.7);
  font-size: 12px;
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-top: 0.75rem;
  padding-top: 0.75rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.task__stats span {
  display: flex;
  align-items: center;
  gap: 0.25rem;
}

.task__stats svg {
  font-size: 10px;
}

.task__owner {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: var(--primary);
  position: absolute;
  display: inline-block;
  right: 0;
  bottom: 0;
  border: 2px solid var(--white);
  box-shadow: var(--shadow-sm);
}

.task-hover {
  border: 2px dashed var(--primary) !important;
  background: var(--primary-light) !important;
}

.empty-column {
  text-align: center;
  color: rgba(255, 255, 255, 0.6);
  padding: 3rem 1rem;
  font-style: italic;
  font-size: 14px;
  border: 2px dashed rgba(255, 255, 255, 0.2);
  border-radius: 12px;
  margin-top: 1rem;
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(5px);
}


/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  backdrop-filter: blur(4px);
}

.modal-content {
  background: var(--white);
  border-radius: 16px;
  padding: 2rem;
  width: 90%;
  max-width: 500px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  border: 1px solid var(--border);
}

.modal-title {
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  color: var(--text);
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.modal-title::before {
  content: '✨';
  font-size: 1.2rem;
}

.form-group {
  margin-bottom: 1rem;
}

.form-label {
  display: block;
  margin-bottom: 0.5rem;
  color: var(--text);
  font-weight: 500;
}

.form-input,
.form-textarea,
.form-select {
  width: 100%;
  padding: 0.875rem;
  border: 2px solid var(--border);
  border-radius: 8px;
  font-size: 1rem;
  background: var(--white);
  color: var(--text);
  transition: all 0.2s ease;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
  outline: none;
  border-color: var(--purple);
  box-shadow: 0 0 0 3px var(--purple-light);
  transform: translateY(-1px);
}

.form-actions {
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
  margin-top: 1.5rem;
}

.btn {
  padding: 0.875rem 1.5rem;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-secondary {
  background: var(--border);
  color: var(--text);
  border: 2px solid var(--border);
}

.btn-secondary:hover {
  background: var(--light-grey);
  border-color: var(--light-grey);
  transform: translateY(-1px);
}

.btn-primary {
  background: linear-gradient(135deg, var(--purple), #8b5cf6);
  color: white;
  box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
}

/* Responsive Design */
@media only screen and (max-width: 1300px) {
  .project {
    max-width: 100%;
  }
  .task-details {
    width: 100%;
    display: flex;
  }
  .tag-progress,
  .task-activity {
    flex-basis: 50%;
    background: var(--white);
    padding: 1rem;
    border-radius: 8px;
    margin: 1rem;
  }
}

@media only screen and (max-width: 1000px) {
  .project-column:nth-child(2),
  .project-column:nth-child(3) {
    display: none;
  }
  .project-tasks {
    grid-template-columns: 1fr 1fr;
  }
}

@media only screen and (max-width: 600px) {
  .project-column:nth-child(4) {
    display: none;
  }
  .project-tasks {
    grid-template-columns: 1fr;
  }
  
  .task-details {
    flex-wrap: wrap;
    padding: 3rem 1rem;
  }
  .tag-progress,
  .task-activity {
    flex-basis: 100%;
  }
  h1 {
    font-size: 25px;
  }
}
</style>