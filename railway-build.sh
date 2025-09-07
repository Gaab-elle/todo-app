#!/bin/bash

# Script de build específico para Railway
echo "🚀 Iniciando build para Railway..."

# Instalar dependências PHP
echo "📦 Instalando dependências PHP..."
composer install --no-dev --optimize-autoloader --no-interaction

# Instalar dependências Node.js
echo "📦 Instalando dependências Node.js..."
npm install --production=false

# Build dos assets
echo "🔨 Buildando assets..."
npm run build

echo "✅ Build concluído com sucesso!"
