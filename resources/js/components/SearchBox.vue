<template>
  <div class="search-box" @click="focusInput">
    <form @submit.prevent="handleSubmit">
      <input 
        ref="searchInput"
        v-model="searchQuery"
        type="text" 
        :placeholder="placeholder"
        class="search-txt"
        autocomplete="off"
        @focus="handleFocus"
        @blur="handleBlur"
        @keypress="handleKeypress"
      />
      <button 
        type="submit" 
        class="search-btn" 
        :title="searchTitle"
        @click="handleSubmit"
      >
        <i class="fas fa-search"></i>
      </button>
    </form>
  </div>
</template>

<script>
export default {
  name: 'SearchBox',
  props: {
    placeholder: {
      type: String,
      default: 'Pesquisar...'
    },
    searchTitle: {
      type: String,
      default: 'Pesquisar'
    },
    searchRoute: {
      type: String,
      default: '/search'
    }
  },
  data() {
    return {
      searchQuery: '',
      isFocused: false
    }
  },
  methods: {
    focusInput() {
      if (this.$refs.searchInput) {
        this.$refs.searchInput.focus()
      }
    },
    handleFocus() {
      this.isFocused = true
    },
    handleBlur() {
      setTimeout(() => {
        this.isFocused = false
      }, 200)
    },
    handleKeypress(event) {
      if (event.key === 'Enter') {
        this.handleSubmit()
      }
    },
    handleSubmit() {
      const query = this.searchQuery.trim()
      if (query) {
        window.location.href = `${this.searchRoute}?q=${encodeURIComponent(query)}`
      }
    }
  },
  mounted() {
    // Keyboard shortcuts
    document.addEventListener('keydown', this.handleKeyboardShortcuts)
  },
  beforeUnmount() {
    document.removeEventListener('keydown', this.handleKeyboardShortcuts)
  },
  methods: {
    focusInput() {
      if (this.$refs.searchInput) {
        this.$refs.searchInput.focus()
      }
    },
    handleFocus() {
      this.isFocused = true
    },
    handleBlur() {
      setTimeout(() => {
        this.isFocused = false
      }, 200)
    },
    handleKeypress(event) {
      if (event.key === 'Enter') {
        this.handleSubmit()
      }
    },
    handleSubmit() {
      const query = this.searchQuery.trim()
      if (query) {
        window.location.href = `${this.searchRoute}?q=${encodeURIComponent(query)}`
      }
    },
    handleKeyboardShortcuts(event) {
      // Ctrl/Cmd + K to focus search
      if ((event.ctrlKey || event.metaKey) && event.key === 'k') {
        event.preventDefault()
        this.focusInput()
      }
      
      // Escape to clear search
      if (event.key === 'Escape' && document.activeElement === this.$refs.searchInput) {
        this.searchQuery = ''
        this.$refs.searchInput.blur()
      }
    }
  }
}
</script>

<style scoped>
/* O CSS está no arquivo search-box.css separado */
</style>
