import { createApp } from 'vue'
import { createPinia } from 'pinia'
import TasksPage from './components/TasksPage.vue'
import TaskCard from './components/TaskCard.vue'

// Make components globally available
window.TasksPageComponent = TasksPage
window.TaskCardComponent = TaskCard

// Make Vue functions globally available
window.createVueApp = createApp
window.createPinia = createPinia

// Global properties for translations
window.$t = function(key) {
    return window.translations && window.translations[key] ? window.translations[key] : key
}

console.log('Vue components loaded:', { TasksPage, TaskCard })
