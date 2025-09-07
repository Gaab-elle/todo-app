#!/bin/bash

# Script de Deploy para Railway
echo "🚀 Iniciando deploy do NERDINO no Railway..."

# Instalar dependências
echo "📦 Instalando dependências PHP..."
composer install --optimize-autoloader --no-dev

echo "📦 Instalando dependências Node.js..."
npm install

# Build dos assets
echo "🔨 Buildando assets..."
npm run build

# Configurar aplicação
echo "⚙️ Configurando aplicação..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Executar migrações
echo "🗄️ Executando migrações..."
php artisan migrate --force

# Limpar cache
echo "🧹 Limpando cache..."
php artisan cache:clear
php artisan config:clear

echo "✅ Deploy concluído com sucesso!"
echo "🌐 Aplicação disponível em: https://your-app.railway.app"
