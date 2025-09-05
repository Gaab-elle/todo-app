import { defineStore } from 'pinia'

export const useTaskStore = defineStore('tasks', {
  state: () => ({
    tasks: [],
    loading: false,
    error: null,
    searchQuery: '',
    selectedProject: null,
    selectedPriority: null,
    selectedStatus: null,
  }),

  getters: {
    filteredTasks: (state) => {
      let filtered = state.tasks

      // Filter by search query
      if (state.searchQuery) {
        const query = state.searchQuery.toLowerCase()
        filtered = filtered.filter(task => 
          task.title.toLowerCase().includes(query) ||
          task.description?.toLowerCase().includes(query) ||
          task.tags?.some(tag => tag.toLowerCase().includes(query))
        )
      }

      // Filter by project
      if (state.selectedProject) {
        filtered = filtered.filter(task => task.project_id === state.selectedProject)
      }

      // Filter by priority
      if (state.selectedPriority) {
        filtered = filtered.filter(task => task.priority === state.selectedPriority)
      }

      // Filter by status
      if (state.selectedStatus) {
        filtered = filtered.filter(task => task.status === state.selectedStatus)
      }

      return filtered
    },

    tasksByStatus: (state) => {
      const tasks = state.filteredTasks
      return {
        pending: tasks.filter(task => task.status === 'pending'),
        in_progress: tasks.filter(task => task.status === 'in_progress'),
        review: tasks.filter(task => task.status === 'review'),
        completed: tasks.filter(task => task.status === 'completed'),
      }
    },

    taskStats: (state) => {
      const tasks = state.tasks
      return {
        total: tasks.length,
        pending: tasks.filter(task => task.status === 'pending').length,
        in_progress: tasks.filter(task => task.status === 'in_progress').length,
        review: tasks.filter(task => task.status === 'review').length,
        completed: tasks.filter(task => task.status === 'completed').length,
      }
    }
  },

  actions: {
    async fetchTasks() {
      this.loading = true
      this.error = null
      
      try {
        const response = await window.axios.get('/api/tasks')
        this.tasks = response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao carregar tarefas'
        console.error('Error fetching tasks:', error)
      } finally {
        this.loading = false
      }
    },

    async createTask(taskData) {
      this.loading = true
      this.error = null
      
      try {
        const response = await window.axios.post('/tasks', taskData)
        this.tasks.push(response.data)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao criar tarefa'
        console.error('Error creating task:', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    async updateTaskStatus(taskId, newStatus) {
      // Don't set loading to true to avoid UI flickering
      this.error = null
      
      try {
        const response = await window.axios.patch(`/tasks/${taskId}/status`, {
          status: newStatus
        })
        
        // Update task in store
        const taskIndex = this.tasks.findIndex(task => task.id == taskId)
        if (taskIndex !== -1) {
          this.tasks[taskIndex].status = newStatus
          console.log('Task updated in store:', this.tasks[taskIndex]) // Debug
        }
        
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao atualizar status'
        console.error('Error updating task status:', error)
        throw error
      }
    },

    async updateTask(taskId, taskData) {
      this.loading = true
      this.error = null
      
      try {
        console.log('Store updateTask called with:', { taskId, taskData })
        console.log('CSRF token:', window.axios.defaults.headers.common['X-CSRF-TOKEN'])
        
        const response = await window.axios.put(`/tasks/${taskId}`, taskData)
        
        console.log('Store updateTask response:', response.data)
        
        // Update task in store
        const taskIndex = this.tasks.findIndex(task => task.id === taskId)
        if (taskIndex !== -1) {
          this.tasks[taskIndex] = { ...this.tasks[taskIndex], ...response.data }
        }
        
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao atualizar tarefa'
        console.error('Error updating task:', error)
        console.error('Error response:', error.response)
        throw error
      } finally {
        this.loading = false
      }
    },

    async deleteTask(taskId) {
      this.loading = true
      this.error = null
      
      try {
        await window.axios.delete(`/tasks/${taskId}`)
        
        // Remove task from store
        this.tasks = this.tasks.filter(task => task.id !== taskId)
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao deletar tarefa'
        console.error('Error deleting task:', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    setSearchQuery(query) {
      this.searchQuery = query
    },

    setSelectedProject(projectId) {
      this.selectedProject = projectId
    },

    setSelectedPriority(priority) {
      this.selectedPriority = priority
    },

    setSelectedStatus(status) {
      this.selectedStatus = status
    },

    clearFilters() {
      this.searchQuery = ''
      this.selectedProject = null
      this.selectedPriority = null
      this.selectedStatus = null
    }
  }
})
