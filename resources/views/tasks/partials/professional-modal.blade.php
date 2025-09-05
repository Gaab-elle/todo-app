<!-- Modal de Criação/Edição Profissional -->
<div x-show="showCreateForm || showEditForm" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-black/70 modal-backdrop flex items-center justify-center p-4 z-50">
    
    <div x-show="showCreateForm || showEditForm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="bg-glass dark:border-white/10 light:border-black/10 border rounded-2xl w-full max-w-lg shadow-refined-xl overflow-hidden"
         @click.away="closeModal()">
         
        <!-- Header do Modal -->
        <div class="bg-gradient-primary p-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold font-poppins text-white flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span x-text="showCreateForm ? '{{ __('messages.create_task') }}' : '{{ __('messages.edit_task') }}'"></span>
                </h2>
                <button @click="closeModal()" 
                        class="text-white/80 hover:text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Corpo do Modal -->
        <div class="p-6 space-y-6 dark:bg-gray-800/50 light:bg-white/50">
            <form @submit.prevent="showCreateForm ? createTask() : updateTask()">
                <!-- Título -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold dark:text-white light:text-gray-900">
                        {{ __('messages.title') }}
                        <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           x-model="formData.title"
                           :placeholder="'{{ __('messages.enter_task_title') }}'"
                           class="w-full bg-glass dark:border-white/10 light:border-black/10 border rounded-xl px-4 py-3 dark:text-white light:text-gray-900 dark:placeholder-gray-400 light:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent transition-all"
                           required>
                </div>

                <!-- Descrição -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold dark:text-white light:text-gray-900">{{ __('messages.description') }}</label>
                    <textarea x-model="formData.description"
                              :placeholder="'{{ __('messages.describe_task') }}'"
                              rows="4"
                              class="w-full bg-glass dark:border-white/10 light:border-black/10 border rounded-xl px-4 py-3 dark:text-white light:text-gray-900 dark:placeholder-gray-400 light:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent transition-all resize-none"></textarea>
                </div>

                <!-- Grid para Prioridade e Data -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Prioridade -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold dark:text-white light:text-gray-900">
                            {{ __('messages.priority') }}
                            <span class="text-red-400">*</span>
                        </label>
                        <select x-model="formData.priority"
                                class="w-full bg-glass dark:border-white/10 light:border-black/10 border rounded-xl px-4 py-3 dark:text-white light:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent transition-all">
                            <option value="low" class="dark:bg-gray-800 light:bg-white">{{ __('messages.low') }}</option>
                            <option value="medium" class="dark:bg-gray-800 light:bg-white">{{ __('messages.medium') }}</option>
                            <option value="high" class="dark:bg-gray-800 light:bg-white">{{ __('messages.high') }}</option>
                        </select>
                    </div>

                    <!-- Data de Vencimento -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold dark:text-white light:text-gray-900">{{ __('messages.due_date') }}</label>
                        <input type="date" 
                               x-model="formData.due_date"
                               class="w-full bg-glass dark:border-white/10 light:border-black/10 border rounded-xl px-4 py-3 dark:text-white light:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent transition-all">
                    </div>
                </div>

                <!-- Preview da Prioridade -->
                <div class="flex items-center space-x-3 p-4 bg-glass dark:border-white/10 light:border-black/10 border rounded-xl">
                    <span class="text-sm font-medium dark:text-white light:text-gray-900">Preview:</span>
                    <span class="px-3 py-1 text-xs font-medium rounded-full border"
                          :class="{
                              'priority-high': formData.priority === 'high',
                              'priority-medium': formData.priority === 'medium',
                              'priority-low': formData.priority === 'low'
                          }"
                          x-text="getPriorityText(formData.priority)"></span>
                </div>

                <!-- Botões de Ação -->
                <div class="flex space-x-4 pt-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-primary hover:shadow-glow text-white px-6 py-3 rounded-xl font-semibold font-poppins transition-all duration-300 hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span x-text="showCreateForm ? '{{ __('messages.create') }}' : '{{ __('messages.update') }}'"></span>
                    </button>
                    <button type="button" 
                            @click="closeModal()"
                            class="flex-1 bg-glass dark:border-white/10 light:border-black/10 border hover:bg-glass-dark dark:text-white light:text-gray-900 px-6 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ __('messages.cancel') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
