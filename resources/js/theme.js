// Theme management functionality
class ThemeManager {
    constructor() {
        this.initializeTheme();
        this.bindEvents();
    }

    initializeTheme() {
        // Get theme from session or default to dark
        const savedTheme = this.getThemeFromSession() || 'dark';
        this.setTheme(savedTheme, false);
    }

    getThemeFromSession() {
        // Try to get from session storage first
        let theme = sessionStorage.getItem('theme');
        
        // If not in session storage, try to get from server
        if (!theme) {
            fetch('/theme/current')
                .then(response => response.json())
                .then(data => {
                    theme = data.theme;
                    sessionStorage.setItem('theme', theme);
                    this.setTheme(theme, false);
                })
                .catch(() => {
                    // Fallback to system preference
                    theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                    this.setTheme(theme, false);
                });
        }
        
        return theme;
    }

    setTheme(theme, persist = true) {
        const html = document.documentElement;
        const body = document.body;
        
        // Remove existing theme classes
        html.classList.remove('dark', 'light');
        body.classList.remove('dark', 'light');
        
        // Add new theme class
        html.classList.add(theme);
        body.classList.add(theme);
        
        // Update toggle button state
        this.updateToggleButton(theme);
        
        // Persist theme if requested
        if (persist) {
            sessionStorage.setItem('theme', theme);
            this.persistThemeToServer(theme);
        }
    }

    updateToggleButton(theme) {
        const toggleButtons = document.querySelectorAll('.theme-toggle');
        toggleButtons.forEach(button => {
            if (theme === 'light') {
                button.classList.add('light');
            } else {
                button.classList.remove('light');
            }
        });
    }

    persistThemeToServer(theme) {
        fetch('/theme/set', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ theme: theme })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.message) {
                this.showNotification(data.message);
            }
        })
        .catch(error => {
            console.warn('Failed to persist theme to server:', error);
        });
    }

    toggleTheme() {
        const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        this.setTheme(newTheme);
    }

    bindEvents() {
        document.addEventListener('click', (e) => {
            if (e.target.closest('.theme-toggle') || e.target.closest('.theme-toggle-alt')) {
                e.preventDefault();
                this.toggleTheme();
            }
        });

        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!sessionStorage.getItem('theme')) {
                this.setTheme(e.matches ? 'dark' : 'light', false);
            }
        });
    }

    showNotification(message) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-gradient-primary text-white px-6 py-3 rounded-xl shadow-glow z-50 animate-slide-up';
        notification.textContent = message;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
}

// Initialize theme manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.themeManager = new ThemeManager();
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ThemeManager;
}
