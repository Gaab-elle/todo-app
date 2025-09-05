// Floating Action Button functionality
class FloatingActionButton {
    constructor() {
        this.isOpen = false;
        this.fab = null;
        this.menu = null;
        this.init();
    }

    init() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.createFAB());
        } else {
            this.createFAB();
        }
    }

    createFAB() {
        // Create FAB container
        const fabContainer = document.createElement('div');
        fabContainer.className = 'fab-container';
        fabContainer.innerHTML = `
            <button class="fab-main" id="fab-main" aria-label="Quick Actions">
                <svg class="fab-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </button>
            <div class="fab-menu" id="fab-menu">
                <a href="/" class="fab-item home" title="Go Home">
                    <svg class="fab-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="fab-tooltip">Go Home</span>
                </a>
                <a href="/tasks" class="fab-item tasks" title="View Tasks">
                    <svg class="fab-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="fab-tooltip">View Tasks</span>
                </a>
                <a href="/projects/create" class="fab-item new-project" title="New Project">
                    <svg class="fab-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span class="fab-tooltip">New Project</span>
                </a>
                <button class="fab-item create-task" title="Create Task" id="fab-create-task">
                    <svg class="fab-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="fab-tooltip">Create Task</span>
                </button>
            </div>
        `;

        // Add to body
        document.body.appendChild(fabContainer);

        // Create modal for task creation
        this.createTaskModal();

        // Get references
        this.fab = document.getElementById('fab-main');
        this.menu = document.getElementById('fab-menu');

        // Add event listeners
        this.fab.addEventListener('click', (e) => {
            e.preventDefault();
            this.toggle();
        });

        // Add event listener for create task button
        const createTaskBtn = document.getElementById('fab-create-task');
        if (createTaskBtn) {
            createTaskBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.close(); // Close FAB menu
                this.openTaskModal();
            });
        }

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (this.isOpen && !fabContainer.contains(e.target)) {
                this.close();
            }
        });

        // Close menu on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.close();
            }
        });

        // Update tooltips with current language
        this.updateTooltips();
    }

    toggle() {
        if (this.isOpen) {
            this.close();
        } else {
            this.open();
        }
    }

    open() {
        this.isOpen = true;
        this.fab.classList.add('open');
        this.menu.classList.add('open');
        
        // Add ripple effect
        this.createRipple();
        
        // Update aria-label
        this.fab.setAttribute('aria-label', 'Close Quick Actions');
    }

    close() {
        this.isOpen = false;
        this.fab.classList.remove('open');
        this.menu.classList.remove('open');
        
        // Update aria-label
        this.fab.setAttribute('aria-label', 'Quick Actions');
    }

    createRipple() {
        const ripple = document.createElement('div');
        ripple.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        `;
        
        const rect = this.fab.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = (rect.width / 2 - size / 2) + 'px';
        ripple.style.top = (rect.height / 2 - size / 2) + 'px';
        
        this.fab.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    createTaskModal() {
        const modal = document.createElement('div');
        modal.id = 'task-modal';
        modal.className = 'task-modal';
        modal.innerHTML = `
            <div class="task-modal-content">
                <div class="task-modal-header">
                    <h2 id="task-modal-title">Criar Nova Tarefa</h2>
                    <button class="task-modal-close" id="task-modal-close">&times;</button>
                </div>
                <form id="task-form" class="task-form">
                    <div class="form-group">
                        <label for="task-title">Título da Tarefa *</label>
                        <input type="text" id="task-title" name="title" placeholder="Digite o título da tarefa..." required>
                    </div>
                    
                    <div class="form-group">
                        <label for="task-description">Descrição</label>
                        <textarea id="task-description" name="description" placeholder="Descreva sua tarefa..." rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="task-priority">Prioridade</label>
                        <select id="task-priority" name="priority">
                            <option value="">Selecionar Prioridade</option>
                            <option value="low">Baixa</option>
                            <option value="medium">Média</option>
                            <option value="high">Alta</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="task-due-date">Data de Vencimento</label>
                        <input type="date" id="task-due-date" name="due_date">
                    </div>
                    
                    <div class="form-group">
                        <label for="task-tags">Tags</label>
                        <input type="text" id="task-tags" name="tags" placeholder="Ex: trabalho, urgente, projeto">
                    </div>
                    
                    <div class="form-group">
                        <label for="task-project">Projeto</label>
                        <select id="task-project" name="project_id">
                            <option value="">Sem Projeto</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" id="task-modal-cancel">Cancelar</button>
                        <button type="submit" class="btn-submit">Criar Tarefa</button>
                    </div>
                </form>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Add event listeners for modal
        this.setupModalEvents();
        
        // Load projects for select
        this.loadProjects();
    }

    setupModalEvents() {
        const modal = document.getElementById('task-modal');
        const closeBtn = document.getElementById('task-modal-close');
        const cancelBtn = document.getElementById('task-modal-cancel');
        const form = document.getElementById('task-form');
        
        // Close modal events
        closeBtn.addEventListener('click', () => this.closeTaskModal());
        cancelBtn.addEventListener('click', () => this.closeTaskModal());
        
        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                this.closeTaskModal();
            }
        });
        
        // Close modal on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('show')) {
                this.closeTaskModal();
            }
        });
        
        // Form submission
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.submitTask();
        });
    }

    openTaskModal() {
        const modal = document.getElementById('task-modal');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        
        // Focus on first input
        setTimeout(() => {
            document.getElementById('task-title').focus();
        }, 100);
    }

    closeTaskModal() {
        const modal = document.getElementById('task-modal');
        modal.classList.remove('show');
        document.body.style.overflow = '';
        
        // Reset form
        document.getElementById('task-form').reset();
    }

    async loadProjects() {
        try {
            const response = await fetch('/api/projects');
            const projects = await response.json();
            
            const select = document.getElementById('task-project');
            select.innerHTML = '<option value="">Sem Projeto</option>';
            
            projects.forEach(project => {
                const option = document.createElement('option');
                option.value = project.id;
                option.textContent = project.name;
                select.appendChild(option);
            });
        } catch (error) {
            console.log('Could not load projects:', error);
        }
    }

    async submitTask() {
        const form = document.getElementById('task-form');
        const formData = new FormData(form);
        
        try {
            const response = await fetch('/tasks', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            if (response.ok) {
                this.closeTaskModal();
                // Show success message
                this.showNotification('Tarefa criada com sucesso!', 'success');
                // Reload page to show new task
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                throw new Error('Failed to create task');
            }
        } catch (error) {
            console.error('Error creating task:', error);
            this.showNotification('Erro ao criar tarefa. Tente novamente.', 'error');
        }
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    updateTooltips() {
        // Try to get translations from Laravel window object
        const tooltips = this.menu.querySelectorAll('.fab-tooltip');
        
        // Check if Laravel translations are available
        if (window.translations) {
            const translations = window.translations;
            
            tooltips.forEach(tooltip => {
                const currentText = tooltip.textContent.trim();
                
                // Map tooltip text to translation keys
                const translationMap = {
                    'Go Home': translations.goHome || 'Go Home',
                    'View Tasks': translations.viewTasks || 'View Tasks',
                    'New Project': translations.createProject || 'New Project',
                    'Create Task': translations.addNewTask || 'Create Task'
                };
                
                if (translationMap[currentText]) {
                    tooltip.textContent = translationMap[currentText];
                }
            });
        } else {
            // Fallback: Try to get current language from meta tag or body class
            const currentLang = document.documentElement.lang || 'en';
            
            // Portuguese translations
            if (currentLang === 'pt' || currentLang.startsWith('pt')) {
                const ptTooltips = {
                    'Go Home': 'Ir para Início',
                    'View Tasks': 'Ver Tarefas',
                    'New Project': 'Novo Projeto', 
                    'Create Task': 'Criar Tarefa'
                };
                
                tooltips.forEach(tooltip => {
                    const currentText = tooltip.textContent.trim();
                    if (ptTooltips[currentText]) {
                        tooltip.textContent = ptTooltips[currentText];
                    }
                });
            }
        }
    }
}

// Initialize FAB when script loads
new FloatingActionButton();

// Add ripple animation CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
