import './bootstrap';
import './theme';
import Alpine from 'alpinejs';

// Função para acessar traduções no Alpine.js
window.__ = function(key) {
    return window.translations && window.translations[key] ? window.translations[key] : key;
};

window.Alpine = Alpine;
Alpine.start();