@extends('layouts.app')

@section('title', __('messages.app_title'))

@section('content')
<div id="vue-tasks-app"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, checking Vue components...');
    console.log('createVueApp:', window.createVueApp);
    console.log('createPinia:', window.createPinia);
    console.log('TasksPageComponent:', window.TasksPageComponent);
    
    if (window.createVueApp && window.createPinia && window.TasksPageComponent) {
        const createApp = window.createVueApp;
        const createPinia = window.createPinia;
        const TasksPage = window.TasksPageComponent;
        
        const app = createApp(TasksPage);
        const pinia = createPinia();
        
        app.use(pinia);
        app.mount('#vue-tasks-app');
        console.log('Vue app mounted successfully!');
    } else {
        console.error('Vue components not found!');
        document.getElementById('vue-tasks-app').innerHTML = '<div style="padding: 20px; color: red;">Erro: Componentes Vue não encontrados. Verifique o console.</div>';
    }
});
</script>
@endpush
