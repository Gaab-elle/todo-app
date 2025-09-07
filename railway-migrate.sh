#!/bin/bash

# Railway Migration Script
echo "=== Running Laravel Migrations on Railway ==="

# Set environment
export APP_ENV=production

# Run migrations
php artisan migrate --force

echo "=== Migrations completed ==="
