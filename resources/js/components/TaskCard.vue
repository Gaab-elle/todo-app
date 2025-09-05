<template>
  <div 
    class="kanban-task"
    :data-task-id="task.id"
    draggable="true"
    @dragstart="handleDragStart"
    @dragend="handleDragEnd"
  >
    <div class="task-title" :class="{ 'line-through text-gray-400': task.completed }">
      {{ task.title }}
    </div>
    
    <div 
      v-if="task.description" 
      class="task-description"
      :class="{ 'line-through': task.completed }"
    >
      {{ truncateText(task.description, 80) }}
    </div>
    
    <div class="task-meta">
      <span 
        class="priority-badge"
        :class="{
          'priority-high': task.priority === 'high',
          'priority-medium': task.priority === 'medium',
          'priority-low': task.priority === 'low'
        }"
      >
        {{ t(`${task.priority}`) }}
      </span>
      <span v-if="task.due_date">{{ formatDate(task.due_date) }}</span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useTaskStore } from '../stores/taskStore'

const props = defineProps({
  task: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['task-updated', 'task-deleted', 'drag-start'])

const taskStore = useTaskStore()

// Global translation function
const t = (key) => {
  return window.translations && window.translations[key] ? window.translations[key] : key
}

const completedSubtasks = computed(() => {
  return props.task.subtasks?.filter(subtask => subtask.completed).length || 0
})

const subtaskProgress = computed(() => {
  if (!props.task.subtasks || props.task.subtasks.length === 0) return 0
  return Math.round((completedSubtasks.value / props.task.subtasks.length) * 100)
})

const truncateText = (text, maxLength) => {
  if (!text) return ''
  return text.length > maxLength ? text.substring(0, maxLength) + '...' : text
}

const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('pt-BR')
}

const handleDragStart = (event) => {
  console.log('TaskCard drag start:', props.task.id) // Debug
  event.target.classList.add('dragging')
  emit('drag-start', event, props.task.id)
}

const handleDragEnd = (event) => {
  console.log('TaskCard drag end') // Debug
  event.target.classList.remove('dragging')
}

const markCompleted = async () => {
  try {
    await taskStore.updateTask(props.task.id, { completed: true })
    emit('task-updated')
  } catch (error) {
    console.error('Error marking task as completed:', error)
  }
}

const deleteTask = async () => {
  if (confirm('Tem certeza que deseja deletar esta tarefa?')) {
    try {
      await taskStore.deleteTask(props.task.id)
      emit('task-deleted')
    } catch (error) {
      console.error('Error deleting task:', error)
    }
  }
}
</script>

<style scoped>
/* Task Styles - Kanban optimized */
.task-title {
  font-size: 16px;
  font-weight: 600;
  color: #ffffff;
  margin-bottom: 8px;
}

.task-description {
  font-size: 14px;
  color: #cbd5e1;
  margin-bottom: 12px;
}

.task-meta {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 12px;
  color: #94a3b8;
}

.priority-badge {
  padding: 4px 8px;
  border-radius: 6px;
  font-weight: 600;
  font-size: 11px;
}

.priority-high { 
  background: #dc2626; 
  color: white; 
}

.priority-medium { 
  background: #f59e0b; 
  color: white; 
}

.priority-low { 
  background: #059669; 
  color: white; 
}

.task-card:hover {
  background: rgba(75, 85, 99, 1);
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Light mode adjustments */
.light .task-card {
  background: rgba(156, 163, 175, 0.8);
  border-color: #9ca3af;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.light .task-card:hover {
  background: rgba(156, 163, 175, 1);
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

/* Smooth priority badge transitions */
.px-2.py-1 {
  transition: all 0.2s ease-in-out;
}

/* Smooth button transitions */
button {
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

button:hover {
  transform: translateY(-1px);
}

/* Smooth text transitions */
h4, p, span {
  transition: all 0.2s ease-in-out;
}

/* Progress bar smooth animation */
.bg-green-500 {
  transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
