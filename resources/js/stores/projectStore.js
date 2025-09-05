import { defineStore } from 'pinia'
import axios from 'axios'

export const useProjectStore = defineStore('projects', {
  state: () => ({
    projects: [],
    loading: false,
    error: null,
  }),

  getters: {
    activeProjects: (state) => state.projects.filter(project => project.is_active),
    favoriteProjects: (state) => state.projects.filter(project => project.is_favorite),
  },

  actions: {
    async fetchProjects() {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.get('/api/projects')
        this.projects = response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao carregar projetos'
        console.error('Error fetching projects:', error)
      } finally {
        this.loading = false
      }
    },

    async createProject(projectData) {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.post('/projects', projectData)
        this.projects.push(response.data)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao criar projeto'
        console.error('Error creating project:', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    async updateProject(projectId, projectData) {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.put(`/projects/${projectId}`, projectData)
        
        // Update project in store
        const projectIndex = this.projects.findIndex(project => project.id === projectId)
        if (projectIndex !== -1) {
          this.projects[projectIndex] = { ...this.projects[projectIndex], ...response.data }
        }
        
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao atualizar projeto'
        console.error('Error updating project:', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    async toggleFavorite(projectId) {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.patch(`/projects/${projectId}/toggle-favorite`)
        
        // Update project in store
        const projectIndex = this.projects.findIndex(project => project.id === projectId)
        if (projectIndex !== -1) {
          this.projects[projectIndex].is_favorite = response.data.is_favorite
        }
        
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao atualizar favorito'
        console.error('Error toggling favorite:', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    async deleteProject(projectId) {
      this.loading = true
      this.error = null
      
      try {
        await axios.delete(`/projects/${projectId}`)
        
        // Remove project from store
        this.projects = this.projects.filter(project => project.id !== projectId)
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao deletar projeto'
        console.error('Error deleting project:', error)
        throw error
      } finally {
        this.loading = false
      }
    }
  }
})
